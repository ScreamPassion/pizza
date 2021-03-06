<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
        $keys = ['desc', 'composition', 'product_name', 'src', 'price', 'discount', 'rating'];
        $arr = [
            ['Невероятно вкусная и аппетитная пицца неизменно получает восторженные отзывы клиентов. Это один из самых популярных заказов нашей службы доставки. Деревенская классическая - блюдо самобытной итальянской кухни, которое приготавливается нашими поварами по традиционной рецептуре. Пицца с хрустящим беконом и нежной свининой с добавлением грибов и сыра моцарелла очень сытная, поэтому сделав заказ для своей семьи или компании друзей, Вы никого не оставите голодным. К Деревенской классической рекомендуем ягодный морс, фруктовые соки или газированные напитки в ассортименте.', 'Бекон, Грибы шампиньоны, Лук красный, Моцарелла, Свинина, Томатный пицца-соус, укроп', 'Пицца Деревенская', '1565858406052_392x320', '3.45', 5, 4],
            ['Вкусная классическая пицца Маргарита на тонком тесте с томатами и сыром моцарелла готовится по традиционному рецепту. Это воплощение классики, которую невозможно испортить. Купить пиццу Маргарита можно на сайте, по телефону и через приложение. Отлично подойдет для всех, в том числе для тех, кто предпочитает вегетарианскую пиццу без мяса. По желанию можно дополнить другими овощами и видами сыра. ', 'Базилик, Моцарелла, Помидоры, Томатный пицца-соус', 'Пицца Маргарита', '1565860404082_392x320', '5.15', 25, 5],
            ['', 'Бекон, Моцарелла, Соус сливочный, Сыр пармезан', 'Пицца Карбонара', '1565859380338_392x320', '3.90', 5, 3],
            ['', 'Моцарелла, Пепперони, Томатный пицца-соус…', 'Пицца Пепперони', '1571649958703_392x320', '4.10', 15, 5],
            ['', 'Колбаски охотничьи, Курица, Моцарелла, Соус барбекю, Томатный пицца-соус, укроп', 'Пицца Барбекю', '1565856863110_392x320', '3.15', 5, 5],
            ['', 'Ветчина, Грибы шампиньоны, Моцарелла, Пепперони, Сыр пармезан, Томатный пицца-соус', 'Пицца Классика', '1565859921301_392x320', '3.70', 10, 3],
            ['', 'Моцарелла, Сливочный пицца-соус, Сыр Дор Блю, Сыр пармезан, Сыр Чеддер', 'Пицца Четыре сыра', '1565875774702_392x320', '4.50', 15, 4],
            ['Большая сытная пицца с ассорти из мяса, которая подойдет на все случаи жизни: плотный обед или ужин, встреча с друзьями. Состав разработан шеф-поваром на основе классических рецептов итальянской кухни. При желании пиццу можно дополнить топпингами на Ваш вкус. На выбор предлагаем два соуса: классический томатный и сливочный. Мясная классическая пицца - одно из самых популярных блюд нашей службы доставки, за которой клиенты возвращаются снова и снова. Готовится на тонком тесте, также есть вариант этой пиццы с двойной начинкой.', 'Грибы шампиньоны, Колбаски охотничьи, Курица, Моцарелла, Пепперони, Свинина, Томатный пицца-соус, укроп', 'Пицца Мясная', '1565869148005_392x320', '4.85', 15, 4],
            ['', 'Грибной жульен (шампиньоны, лук репчатый, сливки), Курица, Лук зеленый, Моцарелла, Сыр пармезан', 'Пицца Марсельеза', '1565860740005_392x320', '2.95', NULL, 2],
            ['', 'Артишоки, Грибы шампиньоны, Лук зеленый, Моцарелла, Оливки, Петрушка, Свинина', 'Пицца Тоскана фирменная', '1571669808623_392x320', '4.80', 40, 5],
            ['', 'Моцарелла, Свинина, Сыр пармезан, Яйцо куриное…', 'Пицца Абруццо фирменная', '1571670806400_392x320', '6.00', 50, 5],
            ['Это сытная мясная пицца на тонком тесте, рецептура которой разработана нашими поварами. Наша собственная вариация на тему лучших итальянских пицц. В составе блюда 4 вида мяса! Но если этого мало, Вы можете добавить свои топпинги по желанию или наоборот убрать какой-либо ингредиент, например, лук или укроп. Это можно сделать при заказе через оператора колл-центра.   Пицца Петровская классическая - это один из хитов продаж нашей службы доставки. Большая сытная пицца, которая уже успела себя отлично зарекомендовать среди постоянных клиентов. ', 'Бекон, Ветчина, Грибы шампиньоны, Курица, Лук красный, Моцарелла, Пепперони, Помидоры, Томатный пицца-соус, укроп', 'Пицца Петровская', '1565870104570_392x320', '3.40', NULL, 4],
        ];

        foreach ($arr as $k => $row) {
            array_walk($row, function ($val, $key) use ($keys, &$arr, $k) {
                $arr[$k][$keys[$key]] = $val;
                unset($arr[$k][$key]);
            });
            (new Product($arr[$k]))->save();
        }
    }
}
