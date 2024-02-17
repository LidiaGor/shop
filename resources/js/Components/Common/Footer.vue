<script setup>

import moment from "moment";

</script>

<template>
    <footer class="footer mt-100">
        <div class="wrapper">

            <section class="footer__list">

                <div class="footer__left">

                    <a href="/" class="footer__logo">
                        <img src="/img/logo.svg" alt="">
                    </a>

                    <a href="tel:+70000000000" class="footer__phone">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.62 7.79C5.06 10.62 7.38 12.93 10.21 14.38L12.41 12.18C12.68 11.91 13.08 11.82 13.43 11.94C14.55 12.31 15.76 12.51 17 12.51C17.55 12.51 18 12.96 18 13.51V17C18 17.55 17.55 18 17 18C7.61 18 0 10.39 0 1C0 0.45 0.45 0 1 0H4.5C5.05 0 5.5 0.45 5.5 1C5.5 2.25 5.7 3.45 6.07 4.57C6.18 4.92 6.1 5.31 5.82 5.59L3.62 7.79Z"
                                  fill="#020203"/>
                        </svg>
                        <span>+7 (000) 000-00-00</span>
                    </a>
                    <a href="mailto:mail@mail.ru" class="footer__mail">
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 0H2C0.9 0 0.00999999 0.9 0.00999999 2L0 14C0 15.1 0.9 16 2 16H18C19.1 16 20 15.1 20 14V2C20 0.9 19.1 0 18 0ZM18 4L10 9L2 4V2L10 7L18 2V4Z"
                                  fill="#020203"/>
                        </svg>
                        <span>mail@mail.ru</span>
                    </a>
                </div>


                <div class="footer__right">

                    <div class="footer_item footer_item_about">
                        <h4>
                            <a href="#">О нас</a>
                        </h4>
                        <ul>

                            <li><a href="#">Реквизиты</a></li>
                            <li><a href="#">Контакты</a></li>
                        </ul>
                    </div>

                    <div class="footer_item footer_item_help">
                        <h4>
                            <a href="#">Помощь</a>
                        </h4>
                        <ul>

                            <li><a href="#">Как сделать заказ</a></li>
                            <li><a href="#">Оплата</a></li>
                            <li><a href="#">Доставка</a></li>
                            <li><a href="#">Возврат товаров</a></li>
                            <li><a href="#">Безопасность</a></li>
                            <li><a href="#">Условия обработки данных</a></li>
                        </ul>
                    </div>

                    <div class="footer_item footer_item_lk">
                        <h4>
                            <a href="#">Покупателям</a>
                        </h4>
                        <ul>

                            <li><a href="/orders.php">Личный кабинет</a></li>
                            <li><a href="/orders.php">Заказы</a></li>
                        </ul>
                    </div>


                </div>
            </section>
        </div>

        <section class="copyright">
            © КладСклад {{ moment().format('YYYY') }}
        </section>
    </footer>
</template>
