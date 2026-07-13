<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public static $countryToContinent = [
        'Ghana' => 'Africa',
        'Nigeria' => 'Africa',
        'Kenya' => 'Africa',
        'South Africa' => 'Africa',
        'Uganda' => 'Africa',
        'Botswana' => 'Africa',
        'Egypt' => 'Africa',
        'Sierra Leone' => 'Africa',
        'Zambia' => 'Africa',
        'Swaziland' => 'Africa',
        'Gambia' => 'Africa',
        'Ethiopia' => 'Africa',
        'Mauritius' => 'Africa',
        'Tunisia' => 'Africa',
        'Tanzania' => 'Africa',
        'Madagascar' => 'Africa',
        'Cape Verde' => 'Africa',
        'Malawi' => 'Africa',
        'Cote DIvoire' => 'Africa',
        'Zaire' => 'Africa',
        'Zimbabwe' => 'Africa',
        'Burkina Faso' => 'Africa',
        'Equatorial Guinea' => 'Africa',

        'Macau' => 'Asia',
        'Uzbekistan' => 'Asia',
        'Japan' => 'Asia',
        'Kyrgyzstan' => 'Asia',
        'Maldives' => 'Asia',
        'Taiwan' => 'Asia',
        'Yemen' => 'Asia',
        'India' => 'Asia',
        'China' => 'Asia',
        'Cyprus' => 'Asia',
        'Cambodia' => 'Asia',
        'Armenia' => 'Asia',
        'Iran' => 'Asia',
        'Israel' => 'Asia',
        'Bahrain' => 'Asia',
        'Korea Sout' => 'Asia',
        'Mongolia' => 'Asia',
        'Malaysia' => 'Asia',
        'Hong Kong' => 'Asia',
        'Singapore' => 'Asia',
        'Turkey' => 'Asia',

        'United Kingdom' => 'Europe',
        'Spain' => 'Europe',
        'Sweden' => 'Europe',
        'Netherlands' => 'Europe',
        'France' => 'Europe',
        'Belgium' => 'Europe',
        'San Marino' => 'Europe',
        'Italy' => 'Europe',
        'Belarus' => 'Europe',
        'Great Britain' => 'Europe',
        'Germany' => 'Europe',
        'Switzerland' => 'Europe',
        'Moldova' => 'Europe',
        'Lithuania' => 'Europe',
        'Albania' => 'Europe',
        'Russia' => 'Europe',
        'Bulgaria' => 'Europe',
        'Ukraine' => 'Europe',

        'Canada' => 'North America',
        'United States of America' => 'North America',
        'Mexico' => 'North America',
        'Greenland' => 'North America',
        'Anguilla' => 'North America',
        'Belize' => 'North America',

        'Brazil' => 'South America',
        'Ecuador' => 'South America',
        'Paraguay' => 'South America',
        'Peru' => 'South America',
        'Trinidad & Tobago' => 'South America',

        'Papua New Guinea' => 'Oceania',
        'Kiribati' => 'Oceania',
        'British Indian Ocean Ter' => 'Oceania',
        'Fiji' => 'Oceania',
        'Australia' => 'Oceania',
        'Midway Islands' => 'Oceania',
        'Guam' => 'Oceania',
    ];
    public function index(Request $request)
    {
        // 1. Base query with search filter
        $baseQuery = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $baseQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('lname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // 2. Get country counts based on current search & tab filter context (BEFORE applying the country filter)
        $countryQuery = clone $baseQuery;
        if ($request->filled('filter')) {
            $filter = $request->input('filter');
            if ($filter === 'with_phone') {
                $countryQuery->whereNotNull('phone')
                             ->where('phone', '<>', '')
                             ->where('phone', '<>', 'N/A');
            } elseif ($filter === 'email_only') {
                $countryQuery->where(function($q) {
                    $q->whereNull('phone')
                      ->orWhere('phone', '')
                      ->orWhere('phone', 'N/A');
                });
            }
        }
        
        $countryCounts = $countryQuery->whereNotNull('country')
                                      ->where('country', '<>', '')
                                      ->where('country', '<>', 'N/A')
                                      ->groupBy('country')
                                      ->selectRaw('country, count(*) as total')
                                      ->pluck('total', 'country');
        $rawCountries = $countryCounts->sortKeys()->all();
        $countries = [];
        foreach ($rawCountries as $name => $count) {
            $continent = self::$countryToContinent[$name] ?? 'Others';
            $countries[$continent][$name] = $count;
        }
        ksort($countries);

        // 3. Get tab counts based on current search & country filter context (BEFORE applying the tab filter)
        $tabCountsQuery = clone $baseQuery;
        if ($request->filled('country')) {
            $tabCountsQuery->where('country', $request->input('country'));
        }

        $allCountQuery = clone $tabCountsQuery;
        $totalAll = $allCountQuery->count();

        $withPhoneQuery = clone $tabCountsQuery;
        $totalWithPhone = $withPhoneQuery->whereNotNull('phone')
                                         ->where('phone', '<>', '')
                                         ->where('phone', '<>', 'N/A')
                                         ->count();

        $emailOnlyQuery = clone $tabCountsQuery;
        $totalEmailOnly = $emailOnlyQuery->where(function($q) {
            $q->whereNull('phone')
              ->orWhere('phone', '')
              ->orWhere('phone', 'N/A');
        })->count();

        // Calculate Ghana tab count
        $ghanaQuery = clone $tabCountsQuery;
        $totalGhana = $ghanaQuery->where('country', 'Ghana')->count();

        // Calculate continent tab counts in a single group-by query
        $continentCountsQuery = clone $tabCountsQuery;
        $dbCountryCounts = $continentCountsQuery->whereNotNull('country')
                                                ->groupBy('country')
                                                ->selectRaw('COALESCE(country, "Unknown") as country_name, count(*) as total')
                                                ->pluck('total', 'country_name')
                                                ->all();

        $continentCounts = [
            'Africa' => 0,
            'Asia' => 0,
            'Europe' => 0,
            'North America' => 0,
            'South America' => 0,
            'Oceania' => 0,
            'Others' => 0
        ];

        foreach ($dbCountryCounts as $cName => $cCount) {
            if ($cName === 'Unknown' || $cName === 'N/A' || $cName === '') {
                $continentCounts['Others'] += $cCount;
            } else {
                $continent = self::$countryToContinent[$cName] ?? 'Others';
                $continentCounts[$continent] += $cCount;
            }
        }

        // 4. Build final query for retrieving paginated users
        $query = clone $tabCountsQuery;
        if ($request->filled('filter')) {
            $filter = $request->input('filter');
            if ($filter === 'with_phone') {
                $query->whereNotNull('phone')
                      ->where('phone', '<>', '')
                      ->where('phone', '<>', 'N/A');
            } elseif ($filter === 'email_only') {
                $query->where(function($q) {
                    $q->whereNull('phone')
                      ->orWhere('phone', '')
                      ->orWhere('phone', 'N/A');
                });
            } elseif ($filter === 'Ghana') {
                $query->where('country', 'Ghana');
            } else {
                // Check if it's a continent filter
                $continents = ['Africa', 'Asia', 'Europe', 'North America', 'South America', 'Oceania', 'Others'];
                if (in_array($filter, $continents)) {
                    if ($filter === 'Others') {
                        $knownCountries = array_keys(self::$countryToContinent);
                        $query->where(function($q) use ($knownCountries) {
                            $q->whereNotIn('country', $knownCountries)
                              ->orWhereNull('country')
                              ->orWhere('country', '')
                              ->orWhere('country', 'N/A');
                        });
                    } else {
                        $countriesInContinent = array_keys(array_filter(self::$countryToContinent, function($c) use ($filter) {
                            return $c === $filter;
                        }));
                        $query->whereIn('country', $countriesInContinent);
                    }
                }
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.users.table_data', compact('users'))->render(),
                'totalAll' => $totalAll,
                'totalWithPhone' => $totalWithPhone,
                'totalEmailOnly' => $totalEmailOnly,
                'totalGhana' => $totalGhana,
                'continentCounts' => $continentCounts,
                'countries' => $countries
            ]);
        }

        return view('admin.users.index', compact('users', 'totalAll', 'totalWithPhone', 'totalEmailOnly', 'totalGhana', 'continentCounts', 'countries'));
    }

    public function continentsPreview(Request $request)
    {
        // 1. Get all unique countries and their total user counts
        $countryCounts = User::groupBy('country')
                             ->selectRaw('COALESCE(country, "Unknown") as country_name, count(*) as total')
                             ->pluck('total', 'country_name')
                             ->all();

        // 2. Fetch users based on filters
        $query = User::query();

        // If "Show Flagged Only" is active (default)
        $showFlaggedOnly = $request->input('flagged_only', '1') === '1';
        
        if ($showFlaggedOnly) {
            $query->where(function($q) {
                // Heuristic for invalid emails: must not match '%_@_%._%'
                $q->where('email', 'not like', '%_@_%._%')
                  // Or match dummy domains
                  ->orWhere('email', 'like', '%@example.com')
                  ->orWhere('email', 'like', '%@test.com')
                  ->orWhere('email', 'like', '%@dummy.com')
                  ->orWhere('email', 'like', '%@domain.com')
                  ->orWhere('email', 'like', '%@mailinator.com');
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('lname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Fetch filtered users
        $filteredUsers = $query->orderBy('name', 'asc')->get();

        // 3. Group the filtered users by Continent -> Country
        $groupedData = [];
        
        // Initialize continents
        $continents = ['Africa', 'Asia', 'Europe', 'North America', 'South America', 'Oceania', 'Others'];
        foreach ($continents as $c) {
            $groupedData[$c] = [];
        }

        foreach ($filteredUsers as $user) {
            $country = $user->country ?: 'Unknown';
            if ($country === 'N/A') {
                $country = 'Unknown';
            }
            $continent = self::$countryToContinent[$country] ?? 'Others';
            
            if (!isset($groupedData[$continent][$country])) {
                $groupedData[$continent][$country] = [
                    'total_count' => $countryCounts[$country] ?? 0,
                    'users' => []
                ];
            }
            
            // Add custom flag to user indicating why it's flagged
            $user->is_invalid_email = false;
            $email = $user->email;
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $user->is_invalid_email = true;
                $user->flag_reason = 'Invalid format';
            } else {
                $dummyDomains = ['example.com', 'test.com', 'dummy.com', 'domain.com', 'mailinator.com'];
                foreach ($dummyDomains as $domain) {
                    if (strpos($email, '@' . $domain) !== false) {
                        $user->is_invalid_email = true;
                        $user->flag_reason = 'Dummy domain';
                        break;
                    }
                }
            }

            $groupedData[$continent][$country]['users'][] = $user;
        }

        // Sort countries alphabetically within each continent and remove empty countries
        foreach ($groupedData as $continent => &$countriesList) {
            if (count($countriesList) > 0) {
                ksort($countriesList);
            } else {
                unset($groupedData[$continent]);
            }
        }

        // 4. Calculate total flagged count for stats card
        $totalFlaggedCount = User::where(function($q) {
                $q->where('email', 'not like', '%_@_%._%')
                  ->orWhere('email', 'like', '%@example.com')
                  ->orWhere('email', 'like', '%@test.com')
                  ->orWhere('email', 'like', '%@dummy.com')
                  ->orWhere('email', 'like', '%@domain.com')
                  ->orWhere('email', 'like', '%@mailinator.com');
            })->count();

        $totalUsersCount = User::count();

        return view('admin.users.continents_preview', compact(
            'groupedData', 
            'totalUsersCount', 
            'totalFlaggedCount', 
            'showFlaggedOnly'
        ));
    }

    public function export(Request $request)
    {
        $segment = $request->input('segment', 'all');
        $columns = $request->input('columns', ['name', 'email', 'phone', 'country', 'subscription_status', 'created_at']);

        $query = User::query();

        switch ($segment) {
            case 'with_phone':
                $query->whereNotNull('phone')
                      ->where('phone', '<>', '')
                      ->where('phone', '<>', 'N/A');
                break;
            case 'email_only':
                $query->where(function($q) {
                    $q->whereNull('phone')
                      ->orWhere('phone', '')
                      ->orWhere('phone', 'N/A');
                });
                break;
            case 'ghana_all':
                $query->where('country', 'Ghana');
                break;
            case 'ghana_phone':
                $query->where('country', 'Ghana')
                      ->whereNotNull('phone')
                      ->where('phone', '<>', '')
                      ->where('phone', '<>', 'N/A');
                break;
            case 'ghana_email':
                $query->where('country', 'Ghana')
                      ->where(function($q) {
                          $q->whereNull('phone')
                            ->orWhere('phone', '')
                            ->orWhere('phone', 'N/A');
                      });
                break;
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $fileName = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($users, $columns) {
            $file = fopen('php://output', 'w');
            
            // CSV Header Row
            $csvHeader = [];
            foreach ($columns as $col) {
                $csvHeader[] = ucwords(str_replace('_', ' ', $col));
            }
            fputcsv($file, $csvHeader);

            // CSV Data Rows
            foreach ($users as $user) {
                $row = [];
                foreach ($columns as $col) {
                    if ($col === 'name') {
                        $row[] = $user->name . ' ' . $user->lname;
                    } elseif ($col === 'subscription_status') {
                        $row[] = $user->subscription_expiry && Carbon::parse($user->subscription_expiry)->isFuture() ? 'Active' : 'Inactive';
                    } elseif ($col === 'created_at') {
                        $row[] = $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : 'N/A';
                    } else {
                        $row[] = $user->{$col} ?? 'N/A';
                    }
                }
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'role_id' => 'required|integer',
            'subscription_expiry' => 'nullable|date',
        ]);

        $user->update([
            'name' => $request->name,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'role_id' => $request->role_id,
            'check_subscription' => $request->has('check_subscription') ? 1 : 0,
            'subscription_expiry' => $request->filled('subscription_expiry') ? Carbon::parse($request->subscription_expiry) : null,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $idsJson = $request->input('ids');
        $ids = json_decode($idsJson, true);

        if (!is_array($ids) || empty($ids)) {
            return redirect()->route('admin.users.index')->with('error', 'No users selected for deletion.');
        }

        // Prevent self-deletion
        if (in_array(auth()->id(), $ids)) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }

        User::whereIn('id', $ids)->delete();

        return redirect()->route('admin.users.index')->with('success', 'Selected users deleted successfully.');
    }
}
