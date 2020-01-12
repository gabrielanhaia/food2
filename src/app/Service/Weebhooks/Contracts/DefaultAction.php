<?php


namespace App\Service\Weebhooks\Contracts;

use App\Models\WebhookUrl;
use App\Service\Webhooks\WebhookExtraDataEnum;
use Eloquent\Enumeration\AbstractEnumeration;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

/**
 * Interface DefaultAction
 * @package App\Service\Weebhooks\Contracts
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
abstract class DefaultAction implements ShouldQueue
{
    /**
     * Register webHooks.
     */
    public function register(): void
    {
        $webHooks = $this->getWebHooks();

        if (sizeof($webHooks) === 0) {
            return;
        }

        dispatch($this);
    }

    /**
     * @return bool
     */
    public function handle()
    {
        $webHooks = $this->getWebHooks();

        if (sizeof($webHooks) === 0) {
            return true;
        }

        foreach ($webHooks as $webHook) {
            $client = new Client();
            $client->post(
                $webHook->uri, [
                'headers' => $this->mountAdditionalData($webHook->id, WebhookExtraDataEnum::POST_HEADER()),
                'json' => [
                    'scope' => $this->getScopeEnum()->value(),
                    'action' => $this->getActionEnum()->value(),
                    'data' => $this->getData(),
                ],
                'query' => $this->mountAdditionalData($webHook->id, WebhookExtraDataEnum::GET_PARAM()),
            ]);
        }

        return true;
    }

    /**
     * Method responsible for prepare the additional data for the weebhook call.
     *
     * @param $webHookId
     * @param $type
     * @return array
     */
    private function mountAdditionalData($webHookId, WebhookExtraDataEnum $type): array
    {
        $additional = [];
        $getAdditional = WebhookUrl::find($webHookId)
            ->webHookParams()
            ->where('type', '=', $type->value())
            ->get();

        if (empty($getAdditional))
            return [];

        foreach ($getAdditional as $data) {
            $additional[$data->name] = $data->value;
        }

        return $additional;
    }

    /**
     * Get web-hooks on database.
     *
     * @return WebhookUrl[]|Collection
     */
    private function getWebHooks()
    {
        return WebhookUrl::select('webhook_urls.*')
            ->join('webhooks', 'webhooks.id', '=', 'webhook_urls.webhook_id')
            ->where('webhooks.scope', '=', $this->getScopeEnum()->value())
            ->where('webhooks.action', '=', $this->getActionEnum()->value())
            ->where('webhook_urls.enabled', '=', true)
            ->get();
    }

    /**
     * Return data to be sent by webhook call.
     *
     * @return array
     */
    abstract public function getData(): array;

    /**
     * @return AbstractEnumeration
     */
    abstract protected function getScopeEnum(): AbstractEnumeration;

    /**
     * @return AbstractEnumeration
     */
    abstract protected function getActionEnum(): AbstractEnumeration;
}
