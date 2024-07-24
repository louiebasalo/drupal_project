<?php

namespace Drupal\url_shortener\Form;

class UrlShortenerService {


  public function generateShortCode($long_url) {

    $char = "abcdefghijklmnopqrstuvwxyz0123456789";
        $length = 6;
        $charlen = strlen($char);

        $random = '';
        for($i = 0; $i < $length; $i++)
        {
            $random .= $char[rand(0, $charlen-1)];
        }

        return $random;

  }

  public function increment_click_counter($data)
  {

  }


}
