3. Как реализуется паттерн Фабричный метод? В чем его отличие от паттерна Фабрика?

Фабричный метод предоставляет своим классам интерфейс с методом для определения экземпляров некоторого класса.
Наследники могут переопределить создаваемый класс. Это позволяет не использовать в коде программы конкретные классы,
а манипулировать абстрактными объектами на более высоком уровне.
Обычно этот шаблон используется, когда:
- Классу заранее неизвестно, объекты каких подклассов ему нужно создавать.
- Класс спроектирован так, чтобы создаваемые им объекты определялись подклассами.
- Класс делегирует свои обязанности одному из нескольких вспомогательных подклассов, и планируется локализовать
знание о том, какой класс принимает эти обязанности на себя.

Рассмотрим пример с генератором рекламы в виде баннеров и popup-окон.
 <?php

// Классы BannerBuilder и PopupBuilder будут реализовывать интерфейс генератора IAdvertisement.

 interface IAdvertisement
 {
     public function build(array $parameters): string;
 }

 class BannerBuilder implements IAdvertisement
 {
     public function build(array $parameters): string
     {
         return 'Возвращаем баннер';
     }
 }

 class PopupBuilder implements IAdvertisement
 {
     public function build(array $parameters): string
     {
         return 'Возвращаем попап';
     }
 }



// Создаем абстрактный фабричный метод и двух его наследников для страницы блога.
 // Метод getAdvertisement() мы называем Фабричным методом, поскольку он отвечает за «изготовление» объекта.
class BlogPage
{
    public function getHtml(): string
    {
        echo 'Бизнес-логика';

        $advertisement = $this->getAdvertisement()->build($this->parameters);

        return 'Бизнес-логика';
    }

    protected function getAdvertisement(): IAdvertisement
    {
        return new BannerBuilder();
    }
}

class BlogPageWithPopup extends BlogPage
{
    protected function getAdvertisement(): IAdvertisement
    {
        return new PopupBuilder();
    }
}
?>


<?php

//Пример использования:

$blogPage = new BlogPage();
$blogPage->getHtml();

$blogPageWithPopup = new BlogPageWithPopup();
$blogPageWithPopup->getHtml();
?>

    Плюсы паттерна:
Фабричные методы избавляют проектировщика от необходимости встраивать в код зависящие от приложения классы.
Создание объектов внутри класса с помощью Фабричного метода всегда оказывается более гибким решением, чем непосредственное создание. Фабричный метод создает в подклассах операции зацепки для предоставления расширенной версии объекта.
Связь с другими классами (модулями) программы уменьшается за счет простоты подмены одного класса другим, а значит на паттерн отлично ложится работа принципа «низкая связанность» (low coupling).
Улучшается тестируемость за счет простоты подмены реализации взаимодействующих классов.
    Минусы паттерна:
Для переопределения Фабричного метода требуется каждый раз создавать новые подклассы.
Чем больше методов с фабриками в классе,  тем больше наследников приходится создавать, чтобы покрыть все возможные варианты на их переопределения.
Особенности реализации:
Фабричный метод может как иметь реализацию в классе (рассмотрено в примере), так и быть абстрактным методом. В первом случае это дает базовую реализацию и не требует обязательных наследников, во втором – позволяет не завязываться на конкретную реализацию, а выбрать при инстанцировании конкретного наследника.
Возможно реализовать не простой Фабричный метод, а с аргументом, по которому происходит поиск нужного класса. Например, аргумент метода используется в операторе switch, который ищет подходящий вариант и возвращает конкретный класс.
Суть Фабричного метода – он позволяет делегировать инстанцирование экземпляров класса подклассам.