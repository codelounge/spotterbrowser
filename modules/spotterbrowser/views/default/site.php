<?php 
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>

<?php echo CL_View::factory('globals/header', array('title' => $title, 'scripts' => $scripts, 'styles' => $styles)); ?>

<?php echo $content; ?>

<?php echo CL_View::factory('globals/footer', array('statistics' => $statistics)); ?>