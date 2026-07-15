<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('navigation_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->string('url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_dropdown')->default(false);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->longText('custom_content')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('navigation_menus')
                ->onDelete('cascade');
        });

        // Seed default menus
        $now = now();

        // 1. Parent Menus
        $constitutionId = DB::table('navigation_menus')->insertGetId([
            'title' => 'Constitution',
            'order' => 1,
            'is_dropdown' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pre1992Id = DB::table('navigation_menus')->insertGetId([
            'title' => 'Pre-4th Republic Laws',
            'order' => 2,
            'is_dropdown' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $post1992Id = DB::table('navigation_menus')->insertGetId([
            'title' => '4th Republic Laws',
            'order' => 3,
            'is_dropdown' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('navigation_menus')->insert([
            [
                'title' => 'Case Laws',
                'url' => '/judgement/Ghana',
                'order' => 4,
                'is_dropdown' => false,
                'parent_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'News',
                'url' => '/News/Ghana-News/1',
                'order' => 5,
                'is_dropdown' => false,
                'parent_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        // 2. Constitution Dropdown Items
        DB::table('navigation_menus')->insert([
            [
                'title' => 'Ghana',
                'url' => '/constitution/Republic/Ghana/1',
                'order' => 1,
                'parent_id' => $constitutionId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Africa',
                'url' => '/constitution/all-countries/1/Africa',
                'order' => 2,
                'parent_id' => $constitutionId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Asia',
                'url' => '/constitution/all-countries/2/Asia',
                'order' => 3,
                'parent_id' => $constitutionId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Europe',
                'url' => '/constitution/all-countries/3/Europe',
                'order' => 4,
                'parent_id' => $constitutionId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'North America',
                'url' => '/constitution/all-countries/4/North-America',
                'order' => 5,
                'parent_id' => $constitutionId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'South America',
                'url' => '/constitution/all-countries/5/South-America',
                'order' => 6,
                'parent_id' => $constitutionId,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        // 3. Pre-1992 Laws Dropdown Items
        DB::table('navigation_menus')->insert([
            [
                'title' => '1st Republic',
                'url' => '/pre_1992_legislation/1/First Republic',
                'order' => 1,
                'parent_id' => $pre1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '2nd Republic',
                'url' => '/pre_1992_legislation/2/Second Republic',
                'order' => 2,
                'parent_id' => $pre1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '3rd Republic',
                'url' => '/pre_1992_legislation/3/Third Republic',
                'order' => 3,
                'parent_id' => $pre1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'NLC Decree',
                'url' => '/pre_1992_legislation/5/NLC Decree',
                'order' => 4,
                'parent_id' => $pre1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'NRC Decree',
                'url' => '/pre_1992_legislation/6/NRC Decree',
                'order' => 5,
                'parent_id' => $pre1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'SMC Decree',
                'url' => '/pre_1992_legislation/7/SMC Decree',
                'order' => 6,
                'parent_id' => $pre1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'AFRC Decree',
                'url' => '/pre_1992_legislation/8/AFRC Decree',
                'order' => 7,
                'parent_id' => $pre1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'PNDC Law',
                'url' => '/pre_1992_legislation/4/PNDC Law',
                'order' => 8,
                'parent_id' => $pre1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        // 4. Post-1992 Laws Dropdown Items
        DB::table('navigation_menus')->insert([
            [
                'title' => 'Acts of Parliament',
                'url' => '/post-1992-legislation/1/Acts of Parliament',
                'order' => 1,
                'parent_id' => $post1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Legislative Instruments',
                'url' => '/post-1992-legislation/only-regulations',
                'order' => 2,
                'parent_id' => $post1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Constitutional Instruments',
                'url' => '/post-1992-legislation/Constitutional-Intruments',
                'order' => 3,
                'parent_id' => $post1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Executive Instruments',
                'url' => '/post-1992-legislation/Executive-Intruments',
                'order' => 4,
                'parent_id' => $post1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Amendments',
                'url' => '/post-1992-legislation/only-amendments',
                'order' => 5,
                'parent_id' => $post1992Id,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_menus');
    }
};
