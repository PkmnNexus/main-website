<?php

namespace App\Contracts;

interface Seoable
{
    public function getSeoTitleSource(): ?string;

    public function getSeoDescriptionSource(): ?string;

    public function getSeoExcerptSource(): ?string;

    public function getSeoKeywordsSource(): ?string;

    public function getSeoRobotsSource(): ?string;

    public function getSeoCanonicalSource(): ?string;

    public function getSeoOgTitleSource(): ?string;

    public function getSeoOgDescriptionSource(): ?string;

    public function getSeoOgTypeSource(): ?string;

    public function getSeoImageSource(): ?string;

    public function getSeoSchemaType(): string;
}
