<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Reserva
 *
 * @property int $id
 * @property int $dui
 * @property string $telefono
 * @property int $estado
 * @property int $leido
 * @property int|null $id_usuario
 * @property int $id_boleto
 *
 * @property Boleto $boleto
 * @property Usuario|null $usuario
 *
 * @package App\Models
 */
class Reserva extends Model
{
	protected $table = 'reservas';
	public $timestamps = false;

	protected $casts = [
		'dui' => 'string',
		'estado' => 'int',
		'leido' => 'int',
        'telefono' => 'string',
        'email' => 'string',
		'id_usuario' => 'int',
		'id_boleto' => 'int'
	];

	protected $fillable = [
		'dui',
		'telefono',
		'estado',
        'email',
		'leido',
		'id_usuario',
		'id_boleto'
	];

	public function boleto()
	{
		return $this->belongsTo(Boleto::class, 'id_boleto');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'id_usuario');
	}
}
