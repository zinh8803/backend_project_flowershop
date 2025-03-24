<?php

namespace App\Services;

use App\Http\Resources\PositionResource;
use App\Models\Position;

class PositionService
{
    public function getAllPositions()
    {
    $positions = Position::all();
    return PositionResource::collection($positions);
        
    }

    public function createPosition($data)
    {
        $position = Position::create($data);
        return new PositionResource($position);
    }

    public function getPositionById($id)
    {
        return Position::findOrFail($id);
    }

    public function updatePosition($id, $data)
    {
        $position = Position::findOrFail($id);
        $position->update($data);
        return $position;
    }

    public function deletePosition($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();
        return true;
    }
}