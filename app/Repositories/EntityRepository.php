<?php

namespace App\Repositories;

use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

abstract class EntityRepository extends \Doctrine\ORM\EntityRepository {
    use PaginatesFromRequest;
}
