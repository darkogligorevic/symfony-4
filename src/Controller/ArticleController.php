<?php


namespace App\Controller;


use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, MarkdownInterface $markdown, AdapterInterface $cache)
    {
        $comments = ['Zvezda le!',
            'bla bla',
            'Dok se zemlja oko sunca krece'
        ];

        $articleContent = <<<E0F
 Планови за **поход на европски трон** на Маракани су прављени од средине 80-их година.
 Звезда је у претходне две деценије остваривала солидне европске резултате састављајући тим од играча из своје Омладинске школе,
 уз повремено довођење младих талентованих фудбалера из малих клубова, углавном у Србији.
 Тандем Џајић-Цветковић решио је да крене другим путем,
 да довођењем најбољих играча на домаћем тржишту створи екипу која би одмах могла да се такмичи на континенталном нивоу,
 а за неколико сезона и буде кандидат за [европске трофеје](https://bs.wikipedia.org/wiki/Spisak_finala_Kupa_evropskih_%C5%A1ampiona_i_UEFA_Lige_prvaka).
 
 Прилику да годину оконча другим међународним трофејом Звезда је потражила у Токију, где јој је ривал био чилеански Коло Коло,
 шампион Јужне Америке. На клупи екипе из Сантјага седео је Мирко Јозић, под чијим руководством је Југославија била омладински првак света,
 а Просинечки најбољи на планети у свом узрасту. Али Роби је, баш као и Стојановић, Маровић, Шабанаџовић и Бинић,
 напустио екипу одмах по освајању титиуле првака Европе.
 Прилику да се прослави добио је најмлађи првотимац нашег клуба, Владимир Југовић.
 Његова два поготка и бриљантна игра на целом терену донели су му награду у виду Тојоте,
 резервисану за најбољег играча утакмице. Трећи гол у великој победи 3:0 дао је Дарко Панчев,
 a Звезда је од финиша првог дела играла са играчем мање због искључења Савићевића.
 **Oсмог децембра 1991. године Звезда је остварила све што један фудбалски клуб може да оствари:
 била је шампион Европе и света.** Са ове дистанце, мало је вероватно да ће иједан клуб са истока Европе то остварити у будућности.
 Опет, то није деловало вероватно ни десет година пре Барија. Прича о славној години овде није завршена.
                                
E0F;

        $item = $cache->getItem('markdown_'.md5($articleContent));
        if (!$item->isHit()){
            $item ->set($markdown->transform($articleContent));
            $cache->save($item);
        }

        $articleContent = $item->get();

        return $this->render('article/show.html.twig',[
            'title'=>ucwords(str_replace('-',' ',$slug)),
            'slug' => $slug,
            'articleContent'=> $articleContent,
            'comments'=>$comments,
            ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        //TODO - actually heart/unheart the article!

        $logger->info('Lajkuju ljudi');

        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}