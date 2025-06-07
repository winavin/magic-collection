<?php

namespace Winavin\MagicCollection\Collections\Trait;

use Illuminate\Database\Eloquent\Relations\Relation;

trait BaseCollectionTrait
{
    public function __call( $method, $arguments )
    {
        if( $this->isEmpty() ) {
            return collect();
        }

        $first = $this->first();

        if( method_exists( $first, $method ) ) {
            $relation = $first->$method();

            if( $relation instanceof Relation ) {
                return $this->flatMap( function( $model ) use ( $method ) {
                    return $model->$method;
                } );
            }
        }

        // If method not found, fallback to parent or throw error
        return parent::__call( $method, $arguments );
    }
}
