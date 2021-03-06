<?php

declare(strict_types=1);

namespace Inkl\WidgetExtPStrip\Plugin\Magento\Framework\Filter;

use Inkl\WidgetExtPStrip\Model\Config;
use Magento\Framework\Filter\Template;

class TemplatePlugin
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeFilter(Template $subject, $value)
    {
        if (is_string($value)) {
            $value = $this->replacePTags($value);
        }
        
        return [$value];
    }

    public function replacePTags(string $value): string
    {
        if ($this->config->isEnabled()) {
            $value = preg_replace('/<p>({{widget.*?}})<\/p>/is', '$1', $value);
            $value = preg_replace('/<p><\/p>/is', '$1', $value);
            $value = preg_replace('/<p>&nbsp;<\/p>/is', '$1', $value);
        }

        return $value;
    }
}
