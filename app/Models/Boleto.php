<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Boleto
 *
 * @property int $id
 * @property Carbon $fecha
 * @property int $id_evento_formato
 * @property int $id_asiento
 * @property bool $estado
 *
 * @property Asiento $asiento
 * @property Evento $evento
 * @property Collection|Reserva[] $reservas
 *
 * @package App\Models
 */
class Boleto extends Model
{
	protected $table = 'boleto';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime',
		'id_evento_zona' => 'int',
		'id_asiento' => 'int',
        'reservado' => 'bool',
		'leido' => 'bool',
	];

	protected $fillable = [
		'fecha',
		'id_evento_zona',
		'id_asiento',
		'reservado',
        'leido',
	];

	public function asiento()
	{
		return $this->belongsTo(Asiento::class, 'id_asiento');
	}

	public function evento()
	{
		return $this->belongsTo(Evento::class, 'id_evento_zona');
	}

	public function reservas()
	{
		return $this->hasMany(Reserva::class, 'id_boleto');
	}
}
