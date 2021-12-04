<?php

namespace App\Controller;

use App\Entity\Authors;
use App\Entity\Books;
use App\Form\BookType;
use App\Service\ImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/books", name="lib_books")
     */
    public function books(EntityManagerInterface $entityManager, Request $request, ImageService $imageService)
    {
        $book = new Books();

        $book_form = $this->createForm(BookType::class, $book);
        $book_form->handleRequest($request);
        if($book_form->isSubmitted() && $book_form->isValid()) {
            $book = $book_form->getData();

            //Check and set Image
            $image = $book_form->get('image')->getData();
            if (!$image){
                $book->setImage('no_image.jpg');
            } else {
                $filename = $imageService->ImageUpload($image);
                $book->setImage($filename);
            }

            $isBookExist = $entityManager->getRepository(Books::class)->findOneBy(['title' => $book->getTitle()]);
            if(!$isBookExist) {
                $isAuthorExist = $entityManager->getRepository(Authors::class)->findOneBy(['name' => $book->getAuthor()]);
                if(!$isAuthorExist) {
                    $author = new Authors();
                    $author->setName($book->getAuthor())
                        ->setQuantity(1)
                        ->addBook($book);

                    $book->addARelations($author);

                    $entityManager->persist($author);
                    $entityManager->flush();
                } else {
                    $isAuthorExist->setQuantity($isAuthorExist->getQuantity() + 1)
                        ->addBook($book);

                    $book->addARelations($isAuthorExist);

                    $entityManager->persist($isAuthorExist);
                    $entityManager->flush();
                }

                $entityManager->persist($book);
                $entityManager->flush();
            } else {
                $this->addFlash(
                    'error',
                    'Book already exist'
                );
            }
        }


        $filter = $request->request->get('filterRadio');
        $order = $request->request->get('orderRadio');
        $input = $request->request->get('filter_option');

        $library = $entityManager->getRepository(Books::class)->findAll();

        if($filter && $input){
            if($order){
                global $library;
                $library = $library->findBy([$filter => $input], [$filter => $order]);
            }
            $library = $library->findBy([$filter => $input]);
        } elseif ((!$filter && $input) || ($filter && !$input)) {
            $this->addFlash(
                'error',
                'You forget choose filter or input'
            );
        }


        $filters = ['title', 'author', 'year'];
        return $this->renderForm('books.html.twig', [
            'form' => $book_form,
            'title' => 'Books',
            'filters' => $filters,
            'library' => $library,
        ]);
    }

    /**
     * @Route ("/books/random_create", name="lib_rand")
     */
    public function rand_create(EntityManagerInterface  $entityManager){

        $authors = ["Чулпан Тимофеева", "Кондрат Владимов", "Кира Котовская", "Пров Нехлюдов", "Тихон Незнанский", "Эсмеральда Удачина", "Фирс Саватьев", "Василий Авченко", "Алевтина Бартенева", "Агапия Мамедова", "Ирада Инина", "Макар Викторов", "Венедикт Петкевич", "Лидия Вонифатьева", "Владислав Лебедь", "Ираклий Ивонин", "Елизавета Бестужева", "Ребекка Алипьева", "Алина Аристархова", "Владислав Асташин", "Паула Багрянцева", "Ангелина Ефросинова", "Хадия Спиридонова", "Индира Минаева", "Федот Амфитеатров", "Фока Семенов", "Надежда Кобзева", "Дмитрий Лойко", "Марфа Гурская", "Созон Шарапов", "Бажена Скатова", "Рузалия Малышева", "Фёдор Осинский", "Фаддей Гурский", "Герман Самсонов", "Мелисса Тропина", "Леонтий Маляров", "Сергей Даньков", "Каре Анкидинова", "Сальма Каверина", "Игорь Никонов", "Филат Сбруев", "Трофим Евтифеев", "Георгий Савинов", "Надежда Кирилова", "Марика Полуектова", "Аристарх Вахтин", "Малика Корнильева", "Айнагуль Маргелова", "Прасковья Данилина"];
        $titles = ["Китайская горькая тыква,Гибискус и Солянка", "Гордей и Огурцы бочковые на зиму в банках", "Крылатые бобы Резеда и Холодец", "Редька,Шабрий и Окрошка на минералке", "Семён и Борщ с грибами", "Китайская горькая тыква Савелий и Уха из ряпушки", "Репа,Чабер и Квашеная капуста по-кубански", "Александр и Салат «Грибное лукошко» с опятами", "Артишок Пров и Грузди соленые", "Патиссон,Огуречная трава и Грузди соленые", "Дана и Стейк из семги в духовке", "Фасоль Ираида и Уха из ряпушки", "Петрушка,Пастернак и Борщ с грибами", "Конон и Заливное из семги", "Ревень Агапия и Окрошка", "Арракача,Римский кориандр и Свекольник на кефире", "Родослав и Ряпушка по-карельски", "Уллюко клубненосный Василий и Заливное из семги", "Кресс-салат,Майоран и Квашеная капуста, тушенная с мясом и картофелем", "Римма и Сало", "Арракача Артём и Заливное из семги", "Хикама,Тмин и Окрошка", "Салима и Кишка", "Люффа Галия и Окрошка на курином бульоне", "Щавель,Портулак и Солянка", "Федот и Рассольник вегетарианский", "Хрен Руслана и Тонкие блины с черемшой", "Фасоль,Барбарис и Ленивые голубцы с курицей", "Евстафий и Помидоры, соленые в банках как бочковые", "Арракача Ея и Окрошка на курином бульоне", "Мангольд,Шамбала и Окрошка на курином бульоне", "Белинда и Свекольник на кефире", "Сараха съедобная Ким и Окрошка", "Любисток,Хрен и Пельмени с индейкой", "Лолита и Вареники", "Кольраби Маргарита и Вареники", "Мака перуанская,Кипрей и Уха из ряпушки", "Наргиза и Заливное из семги", "Трихозант Ждан и Докторская колбаса", "Трихозант,Блошница и Квашеная капуста, тушенная с мясом и картофелем", "Александра и Духовые пирожки с картофелем и луком", "Базилик Юнона и Докторская колбаса", "Фасоль,Душица и Салат оливье", "Авдей и Квашеная капуста по-кубански", "Артишок Мика и Кишка"];
        $descriptions = ["Инопланетянин звонить домой", "Миссис Робинсон, вы пытаетесь меня соблазнить, не так ли?", "Глядя на тебя, крошка", "Пристегните ремни. Будет жёсткая ночка", "Бог мне свидетель, — я никогда больше не буду голодать", "Валяй, порадуй меня!", "Переписчик однажды попытался опросить меня. Я съел его печень с бобами и хорошим кьянти", "Никто не плачет в бейсболе!", "Любовь — это когда не нужно просить прощения", "Построй, и они придут", "Бог мне свидетель, — я никогда больше не буду голодать", "Открой двери модуля, Хал", "Моя прелесть", "Лучший друг парня — это его мать", "Сыграй это, Сэм. Сыграй 'As Time Goes By.' (Сыграй, Сэм, сыграй… 'В память о былых временах')", "Стелла! Эй, Стелла!", "Арестуйте обычных подозреваемых", "А вот и Джонни!", "Шейн. Шейн. Вернись!", "В конце концов, завтра — другой день!", "Я была твоя уже на «здрасьте»", "Ла-дии-да, ла-дии-да", "Честно говоря, моя дорогая, мне наплевать", "Построй, и они придут", "Я достиг этого, мам! Я на вершине мира!", "Моя мать благодарит вас. Мой отец благодарит вас. Моя сестра благодарит вас. И я благодарю вас.", "Моя мать благодарит вас. Мой отец благодарит вас. Моя сестра благодарит вас. И я благодарю вас.", "В конце концов, завтра — другой день!", "О, нет, это не самолёты. Это Красота убила Чудовище.", "Луи, мне кажется, это начало прекрасной дружбы", "Я тебе покажу, моя милая! И твоей собачонке тоже!", "Да пребудет с тобой Сила!", "А вот и Джонни!", "О, Джерри, давай не мечтать о луне: у нас есть звезды", "Покажи мне деньги!", "Я вернусь", "Обожаю запах напалма по утрам!", "Жадность, за отсутствием более подходящего слова — это хорошо", "Я вернусь", "Бог мне свидетель, — я никогда больше не буду голодать", "То, из чего сделаны мечты", "До встречи, детка", "Carpe diem. Ловите момент, мальчики. Сделайте свою жизнь экстраординарной", "Это ты мне сказал?", "То-то, у меня такое ощущение, что мы больше не в Канзасе"];

        $year = rand(1800, 2021);
        $title = $titles[rand(0, 45)];
        $author_name = $authors[rand(0, 50)];
        $description = $descriptions[rand(0, 45)];

        //Checking if book already exist
        $book_repo = $entityManager->getRepository(Books::class)->findBy(["title" => $title]);

        //Hell started. By the way, how can i create function to check and add author?
        if (!$book_repo){
            $book = new Books();
            $book->setTitle($title)
                ->setAuthor($author_name)
                ->setDescription($description)
                ->setYear($year)
                ->setImage('img'.rand(1, 10).'.jpg');
            $entityManager->persist($book);
            $entityManager->flush();

            //Same checking for author
            $author_repo = $entityManager->getRepository(Authors::class)->findBy(["name" => $author_name]);
            if(!$author_repo){
                $author = new Authors();
                $author->setName($author_name)
                    ->setQuantity(1)
                    ->addBook($book);

                $book->addARelations($author);

                $entityManager->persist($author);//save new author
                $entityManager->flush();
            }
            else{
                $author_repo[0]->setQuantity($author_repo[0]->getQuantity() + 1 )
                    ->addBook($book);

                $book->addARelations($author_repo[0]);


                $entityManager->persist($author_repo[0]);//update author
                $entityManager->flush();
            }

            //random set two or more authors (Only two now)
            for($i = 0; $i < 3; $i++){
                if(rand(0, 1) == 1) {
                    $author_name = $authors[rand(0, 50)];
                    $author_repo = $entityManager->getRepository(Authors::class)->findBy(["name" => $author_name]);

                    $book->setAuthor($book->getAuthor() . ',' . $author_name);
                    if (!$author_repo) {
                        $author = new Authors();
                        $author->setName($author_name)
                            ->setQuantity(1)
                            ->addBook($book);

                        $book->addARelations($author);

                        $entityManager->persist($author);
                        $entityManager->flush();
                    } else {
                        $author_repo[0]->setQuantity($author_repo[0]->getQuantity() + 1)
                            ->addBook($book);

                        $book->addARelations($author_repo[0]);

                        $entityManager->persist($author_repo[0]);
                        $entityManager->flush();
                    }
                }
            }

        }
        else {
            //include const or something like count how many times redirected,
            // because in case where all title from 'titles' will be used
            //it become in forever loop.
            // In that case probably use redirect with error 'all books already inside'
            return $this->redirectToRoute('lib_rand');
        }

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('lib_books');
    }


    //try

}