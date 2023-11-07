<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Evento
 *
 * @property int $id
 * @property string $evento
 * @property Carbon $fecha
 * @property string $ruta_imagen
 * @property int|null $id_formato
 *
 * @property Collection|Boleto[] $boletos
 *
 * @package App\Models
 */
class Evento extends Model
{
	protected $table = 'evento';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime',
		'id_formato' => 'int'
	];

	protected $fillable = [
		'evento',
		'fecha',
        'ruta_imagen',
	];

	public function evento_zonas()
	{
		return $this->hasMany(EventoZona::class, 'id_evento');
	}
}
