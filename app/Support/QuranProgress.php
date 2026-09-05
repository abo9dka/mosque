<?php

namespace App\Support;

use App\Models\Student;

class QuranProgress
{
    /**
     * Compute how many distinct ayahs a student has memorized, out of the
     * whole Quran, by merging overlapping/re-logged ayah ranges per surah
     * so re-teaching the same ayahs isn't double-counted.
     *
     * @return array{memorized: int, total: int, percent: float, bySurah: array<int, array{number: int, name: string, ayahs: int, memorized: int}>}
     */
    public static function forStudent(Student $student): array
    {
        $surahs = collect(config('quran.surahs'))->keyBy('number');
        $nameToNumber = collect(config('quran.surahs'))->pluck('number', 'name');
        $total = (int) $surahs->sum('ayahs');

        $rangesBySurah = [];

        $logs = $student->progressLogs()
            ->where('type', 'memorization')
            ->whereNotNull('from_ayah')
            ->whereNotNull('to_ayah')
            ->get(['surah_number', 'surah', 'from_ayah', 'to_ayah', 'score', 'type']);

        foreach ($logs as $log) {
            if ($log->isFailed()) {
                continue; // علامة أقل من الحد الأدنى: يبقى ظاهرًا في السجل لكن لا يُحتسب هنا
            }

            $surahNumber = $log->surah_number ?? $nameToNumber->get($log->surah);

            if (!$surahNumber || !$surahs->has($surahNumber)) {
                continue;
            }

            $rangesBySurah[$surahNumber][] = [
                'from' => max(1, (int) $log->from_ayah),
                'to' => (int) $log->to_ayah,
            ];
        }

        $memorized = 0;
        $bySurah = [];

        foreach ($rangesBySurah as $surahNumber => $ranges) {
            $surah = $surahs->get($surahNumber);
            $maxAyah = $surah['ayahs'];

            usort($ranges, fn ($a, $b) => $a['from'] <=> $b['from']);

            $merged = [];
            foreach ($ranges as $range) {
                $from = min($range['from'], $maxAyah);
                $to = min(max($range['to'], $range['from']), $maxAyah);

                if (empty($merged) || $from > end($merged)['to'] + 1) {
                    $merged[] = ['from' => $from, 'to' => $to];
                } else {
                    $lastIndex = array_key_last($merged);
                    $merged[$lastIndex]['to'] = max($merged[$lastIndex]['to'], $to);
                }
            }

            $covered = array_sum(array_map(fn ($r) => $r['to'] - $r['from'] + 1, $merged));

            $memorized += $covered;
            $bySurah[] = [
                'number' => $surah['number'],
                'name' => $surah['name'],
                'ayahs' => $maxAyah,
                'memorized' => $covered,
            ];
        }

        usort($bySurah, fn ($a, $b) => $a['number'] <=> $b['number']);

        return [
            'memorized' => $memorized,
            'total' => $total,
            'percent' => $total > 0 ? round(($memorized / $total) * 100, 1) : 0.0,
            'bySurah' => $bySurah,
        ];
    }
}
