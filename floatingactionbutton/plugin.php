<?php defined('BLUDIT') or die('Bludit CMS.');

/** Floating Action Button — no theme-specific templates or dependencies. */
class FloatingActionButton extends Plugin
{
    private $fabRendered = false;

    public function init()
    {
        // Keep the original keys so upgrades preserve existing settings.
        $this->dbFields = array(
            'enabled' => 'true',
            'buttonText' => 'Get in Touch',
            'buttonLink' => '/contact-us/',
            'desktopScroll' => '30',
            'mobileScroll' => '40'
        );
    }

    public function form()
    {
        $html = '<div class="alert alert-info">One floating button for your public website. Save your text and destination below. No theme edits are required for themes with standard Bludit hooks.</div>';
        $html .= '<div class="form-group"><label for="fab-enabled">Show floating button</label><select class="form-control" id="fab-enabled" name="enabled">';
        $html .= '<option value="true"'.($this->enabled() ? ' selected' : '').'>Yes</option>';
        $html .= '<option value="false"'.(!$this->enabled() ? ' selected' : '').'>No</option></select></div>';
        $html .= '<div class="form-group"><label for="fab-text">Button text</label><input class="form-control" id="fab-text" name="buttonText" value="'.$this->esc($this->getValue('buttonText', false)).'" required></div>';
        $html .= '<div class="form-group"><label for="fab-link">Button link</label><input class="form-control" id="fab-link" name="buttonLink" value="'.$this->esc($this->getValue('buttonLink', false)).'" placeholder="/contact-us/" required><small>Use a relative URL, https:// URL, mailto: address, tel: number or #anchor. Links open in the same tab.</small></div>';
        foreach (array('desktopScroll' => 'Desktop', 'mobileScroll' => 'Mobile') as $key => $label) {
            $html .= '<div class="form-group"><label for="fab-'.$key.'">'.$label.' — show after scrolling (%)</label><input class="form-control" type="number" min="0" max="100" step="1" id="fab-'.$key.'" name="'.$key.'" value="'.$this->threshold($key).'"><small>0 = immediately; 100 = bottom of page. Mobile means viewport width up to 700px. Button hides again above this threshold.</small></div>';
        }
        $html .= '<p>The button automatically stays hidden on its linked page (query strings and trailing slashes are ignored). Desktop position: bottom center.</p>';
        $html .= '<p>After saving, check a public page. If the button is missing, confirm this plugin is activated, both fields are filled in, and clear any page/CDN cache. The theme must call at least one of siteHead, siteBodyBegin or siteBodyEnd. JavaScript is required for the button to appear.</p>';
        return $html;
    }

    public function siteHead()
    {
        if (!$this->ready()) return '';
        return $this->styles().$this->scripts();
    }

    private function threshold($key)
    {
        $value = $this->getValue($key, false);
        return is_numeric($value) ? max(0, min(100, (int)$value)) : ($key === 'mobileScroll' ? 40 : 30);
    }

    private function scripts()
    {
        $config = json_encode(array('text' => trim((string)$this->getValue('buttonText', false)), 'href' => $this->link(), 'desktopScroll' => $this->threshold('desktopScroll'), 'mobileScroll' => $this->threshold('mobileScroll')), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        return '<script class="floatingactionbutton-config" type="application/json">'.$config.'</script><script defer src="'.$this->esc($this->domainPath().'js/button.js?v=1.2.0').'"></script>';
    }

    public function siteBodyBegin() { return $this->renderButton(); }
    public function siteBodyEnd() { return $this->renderButton(); }

    private function renderButton()
    {
        if ($this->fabRendered || !$this->ready()) return '';
        $this->fabRendered = true;
        return $this->styles().$this->scripts();
    }

    private function styles()
    {
        return '<link rel="stylesheet" href="'.$this->esc($this->domainPath().'css/style.css?v=1.2.0').'">';
    }

    private function enabled()
    {
        return in_array(strtolower(trim((string)$this->getValue('enabled', false))), array('true', '1', 'yes', 'on'), true);
    }

    private function link()
    {
        $link = trim((string)$this->getValue('buttonLink', false));
        if ($link === '' || preg_match('/[\x00-\x20\x7f\\\\]/', $link) || strpos($link, '//') === 0) return '';
        if (preg_match('/^([a-z][a-z0-9+.-]*):/i', $link, $match)
            && !in_array(strtolower($match[1]), array('http', 'https', 'mailto', 'tel'), true)) return '';
        return $link;
    }

    private function ready()
    {
        return $this->enabled() && trim((string)$this->getValue('buttonText', false)) !== '' && $this->link() !== '';
    }

    private function esc($value)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}
