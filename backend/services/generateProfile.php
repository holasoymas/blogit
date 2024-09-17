<?php

function generateRandomColor()
{
  $chars = "0123456789ABCDEF";
  $color = "#";

  // Generate a random hex color
  for ($i = 0; $i < 6; $i++) {
    $randomIndex = mt_rand(0, strlen($chars) - 1);
    $color .= $chars[$randomIndex];
  }

  // Adjust brightness and return the modified color
  return adjustColorBrightness($color, -0.4); // Darken the color
}

function adjustColorBrightness($color, $factor)
{
  // Ensure color starts with #
  $color = ltrim($color, '#');

  // Convert hex to RGB
  $r = hexdec(substr($color, 0, 2));
  $g = hexdec(substr($color, 2, 2));
  $b = hexdec(substr($color, 4, 2));

  // Adjust brightness
  $r = max(0, min(255, $r + $factor * 255));
  $g = max(0, min(255, $g + $factor * 255));
  $b = max(0, min(255, $b + $factor * 255));

  // Convert RGB back to hex and ensure 2 digits per color
  return sprintf("#%02X%02X%02X", $r, $g, $b);
}
