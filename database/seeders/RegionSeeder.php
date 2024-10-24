<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->insert([
            [
                'id' => 1,
                'name' => 'Africa',
                'translations' => json_encode([
                    'ko' => '아프리카',
                    'pt-BR' => 'África',
                    'pt' => 'África',
                    'nl' => 'Afrika',
                    'hr' => 'Afrika',
                    'fa' => 'آفریقا',
                    'de' => 'Afrika',
                    'es' => 'África',
                    'fr' => 'Afrique',
                    'ja' => 'アフリカ',
                    'it' => 'Africa',
                    'zh-CN' => '非洲',
                    'tr' => 'Afrika',
                    'ru' => 'Африка',
                    'uk' => 'Африка',
                    'pl' => 'Afryka',
                ]),
            ],
            [
                'id' => 2,
                'name' => 'Americas',
                'translations' => json_encode([
                    'ko' => '아메리카',
                    'pt-BR' => 'América',
                    'pt' => 'América',
                    'nl' => 'Amerika',
                    'hr' => 'Amerika',
                    'fa' => 'قاره آمریکا',
                    'de' => 'Amerika',
                    'es' => 'América',
                    'fr' => 'Amérique',
                    'ja' => 'アメリカ州',
                    'it' => 'America',
                    'zh-CN' => '美洲',
                    'tr' => 'Amerika',
                    'ru' => 'Америка',
                    'uk' => 'Америка',
                    'pl' => 'Ameryka',
                ]),
            ],
            [
                'id' => 3,
                'name' => 'Asia',
                'translations' => json_encode([
                    'ko' => '아시아',
                    'pt-BR' => 'Ásia',
                    'pt' => 'Ásia',
                    'nl' => 'Azië',
                    'hr' => 'Ázsia',
                    'fa' => 'آسیا',
                    'de' => 'Asien',
                    'es' => 'Asia',
                    'fr' => 'Asie',
                    'ja' => 'アジア',
                    'it' => 'Asia',
                    'zh-CN' => '亚洲',
                    'tr' => 'Asya',
                    'ru' => 'Азия',
                    'uk' => 'Азія',
                    'pl' => 'Azja',
                ]),
            ],
            [
                'id' => 4,
                'name' => 'Europe',
                'translations' => json_encode([
                    'ko' => '유럽',
                    'pt-BR' => 'Europa',
                    'pt' => 'Europa',
                    'nl' => 'Europa',
                    'hr' => 'Európa',
                    'fa' => 'اروپا',
                    'de' => 'Europa',
                    'es' => 'Europa',
                    'fr' => 'Europe',
                    'ja' => 'ヨーロッパ',
                    'it' => 'Europa',
                    'zh-CN' => '欧洲',
                    'tr' => 'Avrupa',
                    'ru' => 'Европа',
                    'uk' => 'Європа',
                    'pl' => 'Europa',
                ]),
            ],
            [
                'id' => 5,
                'name' => 'Oceania',
                'translations' => json_encode([
                    'ko' => '오세아니아',
                    'pt-BR' => 'Oceania',
                    'pt' => 'Oceania',
                    'nl' => 'Oceanië en Australië',
                    'hr' => 'Óceánia és Ausztrália',
                    'fa' => 'اقیانوسیه',
                    'de' => 'Ozeanien und Australien',
                    'es' => 'Oceanía',
                    'fr' => 'Océanie',
                    'ja' => 'オセアニア',
                    'it' => 'Oceania',
                    'zh-CN' => '大洋洲',
                    'tr' => 'Okyanusya',
                    'ru' => 'Океания',
                    'uk' => 'Океанія',
                    'pl' => 'Oceania',
                ]),
            ],
            [
                'id' => 6,
                'name' => 'Polar',
                'translations' => json_encode([
                    'ko' => '남극',
                    'pt-BR' => 'Antártida',
                    'pt' => 'Antártida',
                    'nl' => 'Antarctica',
                    'hr' => 'Antarktika',
                    'fa' => 'جنوبگان',
                    'de' => 'Antarktika',
                    'es' => 'Antártida',
                    'fr' => 'Antarctique',
                    'ja' => '南極大陸',
                    'it' => 'Antartide',
                    'zh-CN' => '南極洲',
                    'tr' => 'Antarktika',
                    'ru' => 'Антарктика',
                    'uk' => 'Антарктика',
                    'pl' => 'Antarktyka',
                ]),
            ],
        ]);
    }
}
