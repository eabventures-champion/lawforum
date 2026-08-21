<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\GhanaAct;
use App\Post1992Act;
use App\Pre1992LegislationAct;
use App\ConstitutionalAct;
use App\ExecutiveAct;
use App\GhLawJudgment;
use App\SearchHistory;

class SearchSuggestionService
{
    /**
     * Curated legal dictionary covering Ghanaian Law, Constitutional Law, Common Law and Civil/Criminal Practice
     */
    protected static $legalDictionary = [
        'juvenile', 'juvenile justice', 'juvenile justice act', 'juvenile court', 'juvenile offender',
        'arbitration', 'arbitrator', 'arbitral tribunal', 'alternative dispute resolution', 'adjudication',
        'constitution', 'constitutional', 'constitutional law', 'constitutional instrument',
        'parliament', 'parliamentary', 'acts of parliament', 'legislation', 'legislative instrument',
        'affidavit', 'injunction', 'interlocutory injunction', 'certiorari', 'mandamus', 'habeas corpus', 'prohibition', 'quo warranto',
        'plaintiff', 'defendant', 'appellant', 'respondent', 'applicant', 'interested party', 'petitioner',
        'prosecution', 'indictment', 'charge sheet', 'plea', 'bail', 'remand', 'committal', 'acquittal', 'conviction',
        'jurisdiction', 'original jurisdiction', 'appellate jurisdiction', 'supervisory jurisdiction', 'review jurisdiction',
        'supreme court', 'court of appeal', 'high court', 'circuit court', 'district court', 'traditional council',
        'chieftaincy', 'chieftaincy act', 'paramount chief', 'stolen property', 'customary law', 'stool lands', 'skin lands',
        'negligence', 'contributory negligence', 'vicarious liability', 'defamation', 'libel', 'slander', 'trespass', 'nuisance',
        'contract', 'breach of contract', 'specific performance', 'damages', 'consideration', 'promissory estoppel',
        'property', 'land act', 'conveyance', 'title deeds', 'leasehold', 'freehold', 'land commission', 'registration of titles',
        'criminal offences', 'criminal offences act', 'criminal code', 'robbery', 'theft', 'fraud', 'defraud by false pretences', 'homicide', 'murder', 'manslaughter',
        'fundamental human rights', 'freedom of expression', 'right to life', 'personal liberty', 'equality before the law',
        'evidence', 'burden of proof', 'standard of proof', 'hearsay', 'admissibility', 'cross examination', 'examination in chief',
        'company', 'companies act', 'director', 'shareholder', 'insolvency', 'liquidation', 'winding up', 'partnership',
        'matrimonial causes', 'marriage act', 'customary marriage', 'divorce', 'custody of children', 'maintenance', 'intestate succession', 'intestate succession law',
        'labour', 'labour act', 'unfair termination', 'redundancy', 'workplace dispute', 'trade union',
        'revenue', 'internal revenue', 'customs', 'taxation', 'value added tax', 'income tax act',
        'copyright', 'trademark', 'patent', 'intellectual property', 'industrial property',
        'extradition', 'foreign judgments', 'international arbitration', 'treaty', 'convention',
        'executive instrument', 'decree', 'proclamation', 'statutory declaration', 'notary public',
        'contempt of court', 'perjury', 'abuse of court process', 'estoppel', 'res judicata',
        'locus standi', 'ultra vires', 'prima facie', 'bona fide', 'mens rea', 'actus reus', 'stare decisis',
        'declaration', 'originating summons', 'writ of summons', 'statement of claim', 'statement of defence',
        'commission on human rights and administrative justice', 'chraj', 'electoral commission', 'lands commission',
        'office of the special prosecutor', 'attorney general', 'solicitor general', 'director of public prosecutions',
        'judicial review', 'statutory interpretation', 'precedent', 'ratio decidendi', 'obiter dicta',
        'probate', 'letters of administration', 'testamentary disposition', 'wills act', 'estate', 'executor', 'beneficiary'
    ];

    /**
     * Get the full searchable legal dictionary and titles (cached for 12 hours)
     */
    public static function getVocabulary()
    {
        return Cache::remember('lawsforum_search_vocabulary_v1', 43200, function () {
            $words = self::$legalDictionary;

            // Load Act titles from database
            try {
                if (class_exists(Post1992Act::class)) {
                    $postActs = Post1992Act::pluck('title')->filter()->toArray();
                    $words = array_merge($words, $postActs);
                }
            } catch (\Exception $e) {}

            try {
                if (class_exists(Pre1992LegislationAct::class)) {
                    $preActs = Pre1992LegislationAct::pluck('title')->filter()->toArray();
                    $words = array_merge($words, $preActs);
                }
            } catch (\Exception $e) {}

            try {
                if (class_exists(GhanaAct::class)) {
                    $ghActs = GhanaAct::pluck('title')->filter()->toArray();
                    $words = array_merge($words, $ghActs);
                }
            } catch (\Exception $e) {}

            try {
                if (class_exists(ConstitutionalAct::class)) {
                    $cActs = ConstitutionalAct::pluck('title')->filter()->toArray();
                    $words = array_merge($words, $cActs);
                }
            } catch (\Exception $e) {}

            try {
                if (class_exists(ExecutiveAct::class)) {
                    $eActs = ExecutiveAct::pluck('title')->filter()->toArray();
                    $words = array_merge($words, $eActs);
                }
            } catch (\Exception $e) {}

            try {
                if (class_exists(AmendRegulationAct::class)) {
                    $amendRegs = AmendRegulationAct::pluck('title')->filter()->toArray();
                    $words = array_merge($words, $amendRegs);
                }
            } catch (\Exception $e) {}

            try {
                if (class_exists(GhAmendedAct::class)) {
                    $ghAmended = GhAmendedAct::pluck('title')->filter()->toArray();
                    $words = array_merge($words, $ghAmended);
                }
            } catch (\Exception $e) {}

            // Load Case Law Titles
            try {
                if (class_exists(GhLawJudgment::class)) {
                    $cases = GhLawJudgment::pluck('case_title')->filter()->toArray();
                    $words = array_merge($words, $cases);
                }
            } catch (\Exception $e) {}

            try {
                if (class_exists(ForeignLawJudgment::class)) {
                    $fCases = ForeignLawJudgment::pluck('case_title')->filter()->toArray();
                    $words = array_merge($words, $fCases);
                }
            } catch (\Exception $e) {}

            // Load Other Constitutions
            try {
                if (class_exists(AllConstitution::class)) {
                    $allConst = AllConstitution::pluck('country_name')->filter()->map(function($c) {
                        return $c . ' Constitution';
                    })->toArray();
                    $words = array_merge($words, $allConst);
                }
            } catch (\Exception $e) {}

            // Load popular search queries
            try {
                if (class_exists(SearchHistory::class)) {
                    $historyTerms = SearchHistory::where('results_count', '>', 0)
                        ->groupBy('search_text')
                        ->orderByRaw('COUNT(*) DESC')
                        ->limit(100)
                        ->pluck('search_text')
                        ->toArray();
                    $words = array_merge($words, $historyTerms);
                }
            } catch (\Exception $e) {}

            // Clean, normalize and unique
            $uniqueMap = [];
            foreach ($words as $w) {
                $clean = trim(preg_replace('/\s+/', ' ', $w));
                if (mb_strlen($clean) >= 2) {
                    $lower = mb_strtolower($clean);
                    if (!isset($uniqueMap[$lower])) {
                        $uniqueMap[$lower] = $clean;
                    }
                }
            }

            return $uniqueMap;
        });
    }

    /**
     * Clear vocabulary cache when documents are added or modified
     */
    public static function clearCache()
    {
        Cache::forget('lawsforum_search_vocabulary_v1');
    }

    /**
     * Provide autocomplete completions for real-time keystrokes
     *
     * @param string $query
     * @param int $limit
     * @return array
     */
    public static function autocomplete($query, $limit = 6)
    {
        $rawQuery = trim($query);
        if (mb_strlen($rawQuery) < 2) {
            return [];
        }

        $lowerQuery = mb_strtolower($rawQuery);
        $vocabulary = self::getVocabulary();

        $prefixMatches = [];
        $containsMatches = [];
        $fuzzyMatches = [];

        foreach ($vocabulary as $lower => $original) {
            if ($lower === $lowerQuery) {
                // Exact match at top
                $prefixMatches[$lower] = [
                    'text' => $original,
                    'type' => self::detectType($original),
                    'is_correction' => false
                ];
            } elseif (strpos($lower, $lowerQuery) === 0) {
                // Starts with query
                $prefixMatches[$lower] = [
                    'text' => $original,
                    'type' => self::detectType($original),
                    'is_correction' => false
                ];
            } elseif (strpos($lower, ' ' . $lowerQuery) !== false || strpos($lower, $lowerQuery) !== false) {
                // Word boundary or substring
                $containsMatches[$lower] = [
                    'text' => $original,
                    'type' => self::detectType($original),
                    'is_correction' => false
                ];
            }
        }

        // If very few prefix or substring matches, look for fuzzy spelling correction
        if (count($prefixMatches) + count($containsMatches) < 3 && mb_strlen($lowerQuery) >= 3) {
            foreach ($vocabulary as $lower => $original) {
                // Only compare against terms of similar length
                if (abs(mb_strlen($lower) - mb_strlen($lowerQuery)) <= 3) {
                    $lev = levenshtein($lowerQuery, substr($lower, 0, mb_strlen($lowerQuery) + 2));
                    if ($lev >= 0 && $lev <= 2) {
                        $fuzzyMatches[$lower] = [
                            'text' => $original,
                            'type' => 'spelling_suggestion',
                            'is_correction' => true
                        ];
                    }
                }
            }
        }

        // Merge: Prefix matches first, then fuzzy corrections, then substring matches
        $merged = array_merge(
            array_values($prefixMatches),
            array_values($fuzzyMatches),
            array_values($containsMatches)
        );

        return array_slice($merged, 0, $limit);
    }

    /**
     * Check if a query is misspelled and suggest the closest correct legal phrase
     *
     * @param string $query
     * @return string|null
     */
    public static function suggestCorrection($query)
    {
        $rawQuery = trim($query);
        if (mb_strlen($rawQuery) < 3) {
            return null;
        }

        $lowerQuery = mb_strtolower($rawQuery);
        $vocabulary = self::getVocabulary();

        // If the exact query is already in vocabulary, no correction needed
        if (isset($vocabulary[$lowerQuery])) {
            return null;
        }

        $bestMatch = null;
        $bestDistance = 999;
        $bestSimilarity = 0;

        $queryLength = mb_strlen($lowerQuery);
        $maxAllowedDistance = ($queryLength >= 7) ? 3 : (($queryLength >= 5) ? 2 : 1);
        $queryWords = preg_split('/\s+/', $lowerQuery);

        foreach ($vocabulary as $lower => $original) {
            $termLength = mb_strlen($lower);

            // 1. Direct whole-phrase fuzzy check (if lengths are close)
            if (abs($termLength - $queryLength) <= $maxAllowedDistance) {
                $lev = levenshtein($lowerQuery, $lower);
                if ($lev >= 1 && $lev <= $maxAllowedDistance) {
                    similar_text($lowerQuery, $lower, $percent);
                    if ($percent >= 65 && ($percent > $bestSimilarity || ($percent == $bestSimilarity && $lev < $bestDistance))) {
                        $bestSimilarity = $percent;
                        $bestMatch = $original;
                        $bestDistance = $lev;
                    }
                }
            }

            // 2. Metaphone similarity check for phonetically misspelled words (e.g. juvinile -> juvenile)
            if (count($queryWords) === 1 && strpos($lower, ' ') === false) {
                if (metaphone($lowerQuery) === metaphone($lower)) {
                    $lev = levenshtein($lowerQuery, $lower);
                    if ($lev <= $maxAllowedDistance && $lev < $bestDistance) {
                        $bestDistance = $lev;
                        $bestMatch = $original;
                    }
                }
            }
        }

        if ($bestMatch && mb_strtolower($bestMatch) !== $lowerQuery) {
            return $bestMatch;
        }

        return null;
    }

    /**
     * Determine category badge for suggestion
     */
    protected static function detectType($text)
    {
        $lower = mb_strtolower($text);
        if (preg_match('/(act|decree|instrument|code|law|order|constitution)/i', $lower)) {
            return 'legislation';
        }
        if (preg_match('/\bv\b|\bversus\b|court of appeal|supreme court|high court/i', $lower)) {
            return 'case_law';
        }
        return 'legal_term';
    }
}
