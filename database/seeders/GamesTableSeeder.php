<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamesTableSeeder extends Seeder
{
   
        public function run()
        {
            DB::table('games')->insert([
                [
                    'title' => 'Cyberpunk 2077',
                    'description' => 'CYBERPUNK 2077 — приключенческая ролевая игра, действие которой происходит в мегаполисе Найт-Сити, где власть, роскошь и модификации тела ценятся выше всего. Вы играете за V, наёмника в поисках устройства, позволяющего обрести бессмертие. Вы сможете менять киберимпланты, навыки и стиль игры своего персонажа, исследуя открытый мир, где ваши поступки влияют на ход сюжета и всё, что вас окружает.',
                    'image' => 'cbp.jpg',
                    'price' => 59.99,
                    'category_id'=>1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'The Witcher 3: Wild Hunt',
                    'description' => '«Ведьмак 3: Дикая Охота» – ролевая игра нового поколения, действие которой разворачивается в удивительном фэнтезийном мире, где необходимо принимать сложные решения и отвечать за их последствия.',
                    'image' => 'witcher.jpg',
                    'price' => 39.99,
                    'category_id'=>2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Elden Ring',
                    'description' => 'НОВЫЙ ФЭНТЕЗИЙНЫЙ РОЛЕВОЙ БОЕВИК.
                     Восстань, погасшая душа! Междуземье ждёт своего повелителя. Пусть благодать приведёт тебя к Кольцу Элден..',
                    'image' => 'elden.jpg',
                    'price' => 79.99,
                    'category_id'=>2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Hogwarts Legacy',
                    'description' => '«Хогвартс. Наследие» – это захватывающая ролевая игра с открытым миром, который известен вам по книгам о Гарри Поттере. Отправляйтесь в путешествие, находите фантастических тварей, меняйте своего персонажа, варите зелья, изучайте заклинания, развивайте таланты, чтобы стать настоящим волшебником.',
                    'image' => 'hogwarts.jpeg',
                    'price' => 99.99,
                    'category_id'=>1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Mortal Kombat 1',
                    'description' => 'Это в нашей крови!
                     Откройте для себя возрожденную вселенную Mortal Kombat™, созданную Богом Огня Лю Кангом.
                     Новое происхождение
                     Совершенно новая вселенная Mortal Kombat 1, отражающая видение совершенства бога огня Лю Канга, знакома, но радикально изменилась.',
                    'image' => 'mk1.jpg',
                    'price' => 74.99,
                    'category_id'=>1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    
}
