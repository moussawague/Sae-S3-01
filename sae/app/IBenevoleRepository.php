<?php

namespace sae;

interface IBenevoleRepository {
    public function saveBenevole(Benevole $benevole): bool;
    public function findUserByEmail(string $email): ?Benevole;
}