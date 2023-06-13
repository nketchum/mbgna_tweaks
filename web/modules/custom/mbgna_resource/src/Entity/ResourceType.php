<?php

namespace Drupal\mbgna_resource\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Resource type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "resource_type",
 *   label = @Translation("Resource type"),
 *   label_collection = @Translation("Resource types"),
 *   label_singular = @Translation("resource type"),
 *   label_plural = @Translation("resources types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count resources type",
 *     plural = "@count resources types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\mbgna_resource\Form\ResourceTypeForm",
 *       "edit" = "Drupal\mbgna_resource\Form\ResourceTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\mbgna_resource\ResourceTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer resource types",
 *   bundle_of = "resource",
 *   config_prefix = "resource_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/resource_types/add",
 *     "edit-form" = "/admin/structure/resource_types/manage/{resource_type}",
 *     "delete-form" = "/admin/structure/resource_types/manage/{resource_type}/delete",
 *     "collection" = "/admin/structure/resource_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class ResourceType extends ConfigEntityBundleBase {

  /**
   * The machine name of this resource type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the resource type.
   *
   * @var string
   */
  protected $label;

}
