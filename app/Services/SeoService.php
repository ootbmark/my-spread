<?php

namespace App\Services;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Twitter;

class SeoService
{


    /**
     * @param $object
     */
    public static function setMeta($object)
    {
        SEOTools::setTitle($object->name);
        SEOTools::setDescription($object->meta_description);
        SEOMeta::addKeyword($object->meta_keywords);
        Twitter::setTitle($object->name);
        SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
        OpenGraph::setUrl(url()->current());

    }


    /**
     * @param $page
     * @param $object
     */
    public static function setPageMeta($page, $object = null)
    {
        switch ($page) {
            case 'login':
                SEOTools::setTitle('Login to Account');
                Twitter::setTitle('Login to account');
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('login, my-spread login, login my-spread, myspread, account');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'register':
                SEOTools::setTitle('Create Account');
                Twitter::setTitle('Create Account');
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('register, my-spread register, register my-spread, myspread, create account');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'contact':
                SEOTools::setTitle("Contact");
                Twitter::setTitle("Contact");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, contact, my-spread contact, contact my-spread, myspread contact, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'help':
                SEOTools::setTitle("Help");
                Twitter::setTitle("Help");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, help, my-spread help, help my-spread, myspread help, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'about':
                SEOTools::setTitle("About");
                Twitter::setTitle("About");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, about, my-spread about, about my-spread, myspread about, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'faq':
                SEOTools::setTitle("FAQ");
                Twitter::setTitle("FAQ");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, faq, my-spread faq, faq my-spread, myspread faq, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'logout':
                SEOTools::setTitle("Logout");
                Twitter::setTitle("Logout");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, logout, my-spread logout, logout my-spread, myspread logout, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'guide':
                SEOTools::setTitle("User Guide");
                Twitter::setTitle("User Guide");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, guide, my-spread guide, guide my-spread, myspread guide, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'privacy':
                SEOTools::setTitle("Privacy");
                Twitter::setTitle("Privacy");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, privacy, my-spread privacy, privacy my-spread, myspread privacy, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'useful':
                SEOTools::setTitle("Useful Links");
                Twitter::setTitle("Useful Links");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, useful, my-spread useful, useful my-spread, myspread useful, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'groups':
                SEOTools::setTitle("Discussion Groups");
                Twitter::setTitle("Discussion Groups");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, groups, my-spread groups, groups my-spread, myspread groups, my spread, discussion groups');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'discussions':
                SEOTools::setTitle("Discussions");
                Twitter::setTitle("Discussions");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, discussions, my-spread discussions, discussions my-spread, myspread discussions, my spread, discussion groups');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'create_discussion':
                SEOTools::setTitle("Start New Discussion");
                Twitter::setTitle("Start New Discussion");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, create discussion, new discussion, my-spread discussion, discussion my-spread, myspread discussion, my spread, discussion create');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'discussion':
                SEOTools::setTitle($object->subject);
                Twitter::setTitle($object->subject);
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, question, discussion, my-spread discussion, discussion my-spread, myspread discussion, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'organisations':
                SEOTools::setTitle("Member Organisations");
                Twitter::setTitle("Member Organisations");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, organisations, my-spread organisations, organisations my-spread, myspread organisations, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'organisation':
                SEOTools::setTitle("Organisation $object->name");
                Twitter::setTitle("Organisation $object->name");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, organisation, my-spread organisation, organisation my-spread, myspread organisation, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'user':
                SEOTools::setTitle("Profile $object->name");
                Twitter::setTitle("Profile $object->name");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, user, my-spread user, user my-spread, myspread user, profile, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'profile':
                SEOTools::setTitle("My Account");
                Twitter::setTitle("My Account");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, my account, profile, my-spread profile, profile my-spread, myspread profile, profile, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            case 'dashboard':
                SEOTools::setTitle("Dashboard");
                Twitter::setTitle("Dashboard");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, dashboard, admin, my-spread dashboard, dashboard my-spread, myspread dashboard, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
            default:
                SEOTools::setTitle("My-Spread Forum");
                Twitter::setTitle("My-Spread Forum");
                SEOTools::setDescription('Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for technical Q&A engineering discussions');
                SEOMeta::addKeyword('forum, my-spread forum, forum my-spread, myspread forum, my spread');
                SEOTools::addImages(['https://my-spread.com/img/map5.jpg']);
                break;
        }
        OpenGraph::setUrl(url()->current());
    }


}
