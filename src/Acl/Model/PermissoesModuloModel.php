<?php

namespace Orangesix\Acl\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissoesModuloModel extends Model
{
    use HasFactory;

    /** @var string */
    public $table = 'acl_permissoes_modulo';
}
