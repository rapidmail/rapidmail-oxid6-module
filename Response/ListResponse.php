<?php

namespace Rapidmail\Oxid6Module\Response;

use OxidEsales\Eshop\Core\Request;
use Rapidmail\Oxid6Module\Model\ListModelInterface;

/**
 * ListResponse
 */
class ListResponse implements ResponseInterface
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ListModelInterface
     */
    private $listModel;

    /**
     * Constructor
     *
     * @param Request $request
     * @param ListModelInterface $listModel
     */
    public function __construct(Request $request, ListModelInterface $listModel)
    {
        $this->request = $request;
        $this->listModel = $listModel;
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return 200;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {

        $itemCount = $this->listModel->getItemCount();
        $pagingInfo = $this->getPagingInfo($itemCount);
        $items = $this->listModel->getItems($pagingInfo)->toArray();

        return (object)[
            'curPage' => $pagingInfo['page'],
            'numPages' => $pagingInfo['pagesTotal'],
            'numObjects' => $itemCount,
            'numCurr' => count($items),
            'result' => $items
        ];

    }

    /**
     * @param int $cnt
     * @return array
     */
    protected function getPagingInfo($cnt)
    {

        $maxPageSize = $this->listModel->getMaxPageSize();
        $page = $this->request->getRequestEscapedParameter('page', 0);
        $pageSize = $this->request->getRequestEscapedParameter('pageSize', $maxPageSize);

        $page = max(0, (int)$page);
        $pageSize = min(max(0, (int)$pageSize), $maxPageSize);

        $pagesTotal = $cnt > 0 ? (ceil($cnt / $pageSize)) : 1;

        return [
            'page' => $page,
            'pageSize' => $pageSize,
            'pagesTotal' => $pagesTotal,
            'offset' => $page * $pageSize,
            'limit' => $pageSize
        ];

    }

}