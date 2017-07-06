# Laravel Larrock CMS :: Reviews Component

---

#### Depends
- fanamurov/larrock-core
- fanamurov/larrock-users

## INSTALL

1. Install larrock-core, larrock-users
2. Install larrock-reviews
  ```sh
  composer require fanamurov/larrock-reviews
  ```

4. Add the ServiceProvider to the providers array in app/config/app.php
  ```
  //LARROCK COMPONENT REVIEWS DEPENDS
  \Larrock\ComponentReviews\LarrockComponentReviewsServiceProvider::class
  ```

5. Publish views, migrations etc.
  ```sh
  $ php artisan vendor:publish
  ```
  Or
  ```sh
  $ php artisan vendor:publish --provider="Larrock\ComponentReviews\LarrockComponentReviewsServiceProvider"
  ```
       
6. Run artisan command:
  ```sh
  $ php artisan larrock:check
  ```
  And follow the tips for setting third-party dependencies
  
  
7. Run migrations
  ```sh
  $ php artisan migrate
  ```

##START
http://yousite/admin/reviews