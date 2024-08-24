<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Menampilkan data dasar dari Content
        $data = [
            'id_content' => $this->id_content,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'description_short' => $this->description_short,
            'image' => $this->image,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->createdBy ? $this->createdBy->name : 'Unknown',
            'updated_by' => $this->updatedBy ? $this->updatedBy->name : 'Unknown',
        ];

        // Menambahkan data relasi arsip jika ada dan tipe bukan 'profil'
        if ($this->type !== 'profil' && $this->arsip) {
            $data['arsip'] = [
                // 'id_arsip' => $this->arsip->id,
                'tahun' => $this->arsip->tahun,
                'bulan' => $this->arsip->bulan,
            ];
        }

        // Menambahkan data relasi kategori jika ada dan tipe bukan 'profil'
        if ($this->type !== 'profil' && $this->category) {
            $data['category'] = [
                // 'id_category' => $this->category->id,
                'name' => $this->category->name,
            ];
        }

        return $data;
    }
}
