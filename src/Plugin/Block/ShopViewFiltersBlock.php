<?php

namespace Drupal\mbgna_tweaks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a shop view filters block.
 *
 * @Block(
 *   id = "mbgna_tweaks_shop_view_filters",
 *   admin_label = @Translation("Shop view filters"),
 *   category = @Translation("Custom")
 * )
 */
class ShopViewFiltersBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $bid = 'mbgna_dxpr_exposedformproducts_mbgnapage_1';
    $block = \Drupal\block\Entity\Block::load($bid);
    $render = \Drupal::entityTypeManager()
            ->getViewBuilder('block')
            ->view($block);
    return $render;
  }

}
