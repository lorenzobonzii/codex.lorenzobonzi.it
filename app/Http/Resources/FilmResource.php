<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return $this->getCampi();
    }

    protected function getCampi()
    {
        return [
            "id" => $this->id,
            "titolo" => $this->titolo,
            "regia" => $this->regia,
            "attori" => $this->attori,
            "anno" => $this->anno,
            "durata" => $this->durata,
            "lingua" => $this->lingua,
            "copertina_v" => $this->copertina_v,
            "copertina_o" => $this->copertina_o,
            "genres_ids" => $this->genres->pluck('id')->toArray(),
            "url_copertina_v" => preg_match('/^\/storage\/[a-zA-Z0-9.\/_]+$/', $this->copertina_v) ? "https://codex.lorenzobonzi.it" . $this->copertina_v : "https://image.tmdb.org/t/p/original" . $this->copertina_v,
            "url_copertina_o" => preg_match('/^\/storage\/[a-zA-Z0-9.\/_]+$/', $this->copertina_o) ? "https://codex.lorenzobonzi.it" . $this->copertina_o : "https://image.tmdb.org/t/p/original" . $this->copertina_o,
            "url_copertina_o_min" => preg_match('/^\/storage\/[a-zA-Z0-9.\/_]+$/', $this->copertina_o) ? "https://codex.lorenzobonzi.it" . $this->copertina_o : "https://image.tmdb.org/t/p/w500" . $this->copertina_o,
            //"url_copertina_v" => preg_match('/^\/img\/[a-zA-Z0-9.]+$/', $this->copertina_v) ? $this->base64_encode_image("https://codex.lorenzobonzi.it" . $this->copertina_v) : $this->base64_encode_image("https://image.tmdb.org/t/p/w500" . $this->copertina_v),
            // "url_copertina_o" => preg_match('/^\/img\/[a-zA-Z0-9.]+$/', $this->copertina_o) ? $this->base64_encode_image("https://codex.lorenzobonzi.it" . $this->copertina_o) : $this->base64_encode_image("https://image.tmdb.org/t/p/w500" . $this->copertina_o),
            "anteprima" => $this->anteprima,
            "trama" => $this->trama,
            "nation" => $this->nation,
            "genres" => $this->genres,
        ];
    }
    protected function base64_encode_image($url)
    {
        $image = file_get_contents($url);
        $arr = explode('.', $url);
        $ext = end($arr);

        if ($image !== false) {
            return 'data:image/' . $ext . ';base64,' . base64_encode($image);
        }
    }
}
