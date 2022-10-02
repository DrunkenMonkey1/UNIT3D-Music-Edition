<?php

namespace App\Rules;

use App\Helpers\EmailBlacklistUpdater;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use Psr\SimpleCache\InvalidArgumentException;

use function in_array;
use function cache;
use function config;
use function explode;
use function strtolower;
use function array_merge;

class EmailBlacklist implements Rule
{
    /**
     * Array of blacklisted domains.
     */
    private array $domains = [];

    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        // Load blacklisted domains
        $this->refresh();

        // Extract domain from supplied email address
        $domain = Str::after(strtolower($value), '@');

        // Run validation check
        return ! in_array($domain, $this->domains, true);
    }

    /**
     * Retrive the latest selection of blacklisted domains and cache them.
     */
    public function refresh(): void
    {
        $this->shouldUpdate();
        $this->domains = cache()->get(config('email-blacklist.cache-key'));
        $this->appendCustomDomains();
    }

    /**
     * Should update blacklist?.
     */
    protected function shouldUpdate(): void
    {
        $autoupdate = config('email-blacklist.auto-update');

        try {
            if ($autoupdate && ! cache()->has(config('email-blacklist.cache-key'))) {
                EmailBlacklistUpdater::update();
            }
        } catch (InvalidArgumentException) {
        }
    }

    /**
     * Append custom defined blacklisted domains.
     */
    protected function appendCustomDomains(): void
    {
        $appendList = config('email-blacklist.append');
        if ($appendList === null) {
            return;
        }

        $appendDomains = explode('|', strtolower($appendList));
        $this->domains = array_merge($this->domains, $appendDomains);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'Email domain is not allowed. Throwaway email providers are blacklisted.';
    }
}
