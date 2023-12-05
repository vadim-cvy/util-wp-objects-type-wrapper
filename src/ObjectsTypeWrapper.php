<?php
namespace Cvy\WP\ObjectsTypeWrapper;

use \Cvy\WP\ObjectsQuery\ObjectsQuery;

abstract class ObjectsTypeWrapper extends \Cvy\DesignPatterns\Singleton
{
  abstract public function get_label_single() : string;

  abstract public function get_label_multiple() : string;

  abstract static public function get_slug() : string;

  abstract static public function wrap_one( int $object_id ) : object;

  static final public function wrap_many( array $object_ids ) : array
  {
    $objects = [];

    foreach ( $object_ids as $id )
    {
      $objects[] = static::wrap_one( $id );
    }

    return $objects;
  }

  static final public function get( array $query_args = [] ) : array
  {
    $ids = static::build_query( $query_args )->get_results();

    return static::wrap_many( $ids );
  }

  abstract static public function get_all( array $query_args = [] ) : array;

  static public function build_query( array $query_args = [] ) : ObjectsQuery
  {
    return static::get_query_instance( $query_args );
  }

  abstract static protected function get_query_instance( array $query_args ) : ObjectsQuery;
}
