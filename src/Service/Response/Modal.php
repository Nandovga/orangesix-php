<?php

namespace Orangesix\Service\Response;

use Orangesix\Service\Response\Enum\Modal as ModalEnum;

class Modal
{
    /** @var string */
    public string $modal;

    /** @var ModalEnum  */
    public ModalEnum $action;

    /**
     * @param string $modal
     * @param ModalEnum $action
     */
    public function __construct(string $modal, ModalEnum $action = ModalEnum::Open)
    {
        $this->modal = $modal;
        $this->action = $action;
    }
}
