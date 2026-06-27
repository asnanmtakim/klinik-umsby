<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    protected $dataView = [];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        $this->helpers = ['text', 'app'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        setting()->set('App.siteTitle', 'Klinik Pratama Rawat Inap UMSURA');
        setting()->set('App.siteTitle', 'UMSURA Inpatient Primary Clinic', 'lang:en');
        setting()->set('App.siteName', 'Klinik Pratama Rawat Inap UMSURA');
        setting()->set('App.siteName', 'UMSURA Inpatient Primary Clinic', 'lang:en');
        setting()->set('App.siteDescription', 'Klinik Pratama Rawat Inap UMSURA menyediakan pelayanan medis berkualitas, profesional, dan terjangkau untuk masyarakat umum dan civitas akademika dengan fasilitas lengkap.');
        setting()->set('App.siteDescription', 'UMSURA Inpatient Primary Clinic provides high-quality, professional, and affordable medical services for the general public and academic community with complete facilities.', 'lang:en');
        setting()->set('App.siteAddress', 'Jl. Sutorejo No. 59 Surabaya, Jawa Timur, Indonesia 60113');
        setting()->set('App.siteAddress', 'Jl. Sutorejo No. 59 Surabaya, East Java, Indonesia 60113', 'lang:en');
        setting()->set('App.siteEmail', 'rektorat@um-surabaya.ac.id');
        setting()->set('App.siteEmail', 'rektorat@um-surabaya.ac.id', 'lang:en');
        setting()->set('App.sitePhone', '+62313811966');
        setting()->set('App.sitePhone', '+62313811966', 'lang:en');
        setting()->set('App.siteGMaps', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31662.62809051156!2d112.788989!3d-7.260349!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f9f4f7d60053%3A0xfd3d82ee40e4ec1!2sUniversitas%20Muhammadiyah%20Surabaya!5e0!3m2!1sid!2sid!4v1683017335908!5m2!1sid!2sid');
        setting()->set('App.siteGMaps', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31662.62809051156!2d112.788989!3d-7.260349!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f9f4f7d60053%3A0xfd3d82ee40e4ec1!2sUniversitas%20Muhammadiyah%20Surabaya!5e0!3m2!1sen!2sid!4v1683017212295!5m2!1sen!2sid', 'lang:en');
        setting()->set('App.siteIcon', '/uploads/site/umsby.png');
        setting()->set('App.siteLogoDark', '/uploads/site/umsura.png');
        setting()->set('App.siteLogoLight', '/uploads/site/umsura_light.png');
        setting()->set('App.siteFacebook', 'https://www.facebook.com/unmuhsby');
        setting()->set('App.siteFacebook', 'https://www.facebook.com/unmuhsby', 'lang:en');
        setting()->set('App.siteInstagram', 'https://www.instagram.com/umsurabaya');
        setting()->set('App.siteInstagram', 'https://www.instagram.com/umsurabaya', 'lang:en');
        setting()->set('App.siteTwitter', 'https://www.x.com/umsby');
        setting()->set('App.siteTwitter', 'https://www.x.com/umsby', 'lang:en');
        setting()->set('App.siteYoutube', 'https://www.youtube.com/umsurabaya1912');
        setting()->set('App.siteYoutube', 'https://www.youtube.com/umsurabaya1912', 'lang:en');
        setting()->set('App.siteWhatsapp', 'https://wa.me/62313811966');
        setting()->set('App.siteWhatsapp', 'https://wa.me/62313811966', 'lang:en');

        if (auth()->loggedIn()) {
            $SiteMenusModel = new \App\Models\SiteMenusModel();
            $menus = $SiteMenusModel->getActiveMenus();
            foreach ($menus as $key => $menu) {
                $menus[$key]['child'] = $SiteMenusModel->getActiveChildMenu($menu['id']);
                foreach ($menus[$key]['child'] as $key2 => $submenu) {
                    $menus[$key]['child'][$key2]['child'] = $SiteMenusModel->getActiveChildMenu($submenu['id']);
                }
            }
            $this->dataView['siteMenus'] = $menus;
            $this->dataView['route'] = $SiteMenusModel->getOneActiveMenubyRoute(getRouteName());
        }
    }
}
