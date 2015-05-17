<?php

// Register routes.

// Homepage
$app->get('/', 'JimmyPhimmasone\Controller\IndexController::indexAction')
    ->bind('homepage');

// Gallery
$app->get('/gallery/', 'JimmyPhimmasone\Controller\GalleryController::indexAction')
    ->bind('gallery');

// Albums
$app->get('/collections/{collectionId}/', 'JimmyPhimmasone\Controller\AlbumsController::albumsAction');

// Photos
$app->get('/albums/{albumId}/', 'JimmyPhimmasone\Controller\AlbumsController::photosAction');

// About me
$app->get('/about-me/', 'JimmyPhimmasone\Controller\AboutMeController::indexAction')
    ->bind('about-me');

// Contact
$app->get('/contact/', 'JimmyPhimmasone\Controller\ContactController::indexAction')
    ->bind('contact');

// Send email
$app->post('/send-email/', 'JimmyPhimmasone\Controller\ContactController::sendEmailAction')
    ->bind('send-email');


/*******
********
**BLOG**
********
*******/

// Index
$app->get('/blog/', 'Blog\Controller\IndexController::indexAction')
    ->bind('blog');

// Quotes of the day
$app->get('/blog/quote-of-day/', 'Blog\Controller\QuoteController::indexAction')
    ->bind('blog-quote');


/*********
**********
ADMIN
**********
*********/

// Login
$app->get('/login/', 'Admin\Controller\LoginController::indexAction')
    ->bind('admin-login');

// Admin
$app->get('/admin/', 'Admin\Controller\IndexController::indexAction')
    ->bind('admin-homepage');

/**
 * COLLECTIONS
 */

// List All
$app->get('/admin/collections/', 'Admin\Controller\CollectionController::collectionsAction')
    ->bind('admin-collections');

// List all albums from a collection 
$app->get('/admin/collections/{collectionId}/albums/', 'Admin\Controller\CollectionController::albumsAction');

// List one 
$app->get('/admin/collections/{collectionId}/', 'Admin\Controller\CollectionController::collectionAction');

// Update
$app->post('/admin/collections/{collectionId}/', 'Admin\Controller\CollectionController::updateCollectionAction');

/**
 * ALBUMS 
 */

// List all
$app->get('/admin/albums/', 'Admin\Controller\AlbumController::albumsAction')
    ->bind('admin-albums');

// List all photos from an album 
$app->get('/admin/albums/{albumId}/photos/', 'Admin\Controller\AlbumController::photosAction');

// List one
$app->get('/admin/albums/{albumId}/', 'Admin\Controller\AlbumController::albumAction');

// Update
$app->post('/admin/albums/{albumId}/', 'Admin\Controller\AlbumController::updateAlbumAction');

/**
 * PHOTOS 
 */

// List all
$app->get('/admin/photos/', 'Admin\Controller\PhotoController::photosAction')
    ->bind('admin-photos');

// List one
$app->get('/admin/photos/{photoId}/', 'Admin\Controller\PhotoController::photoAction');

// Update
$app->post('/admin/photos/{photoId}/', 'Admin\Controller\PhotoController::updatePhotoAction');

// Cover
$app->get('/admin/photos/{photoId}/cover/', 'Admin\Controller\PhotoController::coverAction');

/**
 * IMPORTATION
 *
 */

// Collection
$app->get('/admin/import/collections/', 'Admin\Controller\ImportController::collectionsAction')
    ->bind('import-collections');

// Albums
$app->get('/admin/import/albums/', 'Admin\Controller\ImportController::albumsAction')
    ->bind('import-albums');

// Photos
$app->get('/admin/import/photos/', 'Admin\Controller\ImportController::photosAction')
    ->bind('import-photos');

/**
 * ITINERARY
 *
 */

// One
$app->get('/admin/itinerary/{collectionId}/', 'Admin\Controller\ItineraryController::itineraryAction')
    ->bind('admin-itinerary');

// Search
$app->post('/admin/itinerary/search/', 'Admin\Controller\ItineraryController::searchAction')
    ->bind('admin-itinerary-search');

// Add
$app->post('/admin/itinerary/{collectionId}/add/', 'Admin\Controller\ItineraryController::addAction')
    ->bind('admin-itinerary-add');

// Delete
$app->post('/admin/itinerary/delete/', 'Admin\Controller\ItineraryController::deleteAction')
    ->bind('admin-itinerary-delete');

/**
 * BLOG
 *
 */

// Articles
$app->get('/admin/blog/articles/', 'Admin\Controller\BlogController::articlesAction')
    ->bind('admin-blog-articles');