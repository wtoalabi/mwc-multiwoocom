<?php
  /**
   * Created by Alabi Olawale
   * Date: 08/07/2020
   */
  
  namespace App\Core\Hooks;
  
  use function Config\config;
  
  class Hooks
  {
    public static function Bootstrap() {
      if (array_key_exists('page', $_GET)) {
        if ($_GET['page'] == config('plugin_page')) {
          Scripts::Load();
          Locale::Load();
          Styles::Load();
          Plugs::Load();
        }
      }
      Endpoints::Load();
      Menu::Load();
    }
  }
