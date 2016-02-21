<?php

namespace Domain\ReadModel;

interface BulkProjectionStorage extends ProjectionStorage
{
    public function flush();
}