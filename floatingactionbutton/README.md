# Floating Action Button for Bludit

## Give visitors a clear next step while they scroll

Keep your contact link within reach. Floating Action Button is a free Bludit CMS plugin that adds a fixed call-to-action button to your website. Invite visitors to book a consultation, request a quote, call your business or explore a useful page—using your own button text and destination.

Choose when it appears with separate desktop and mobile scroll percentages. Your message stays out of the way until visitors reach the point you select, then remains accessible as they continue reading.

![Floating Action Button for Bludit promotional preview](screenshot.png)

*Promotional illustration, not a live screenshot. The bundled plugin uses a navy button; this artwork uses orange for emphasis. Button colors are not configurable in the settings.*

## Why use this Bludit call-to-action plugin

- **Write your own invitation.** Use “Book a Consultation”, “Request a Quote” or another relevant next step.
- **Send visitors where you choose.** Link to a contact page, booking page, email address or phone number.
- **Control the timing by device.** Set different scroll percentages for desktop and mobile visitors.
- **Keep the contact page uncluttered.** The button hides on its linked page when that destination is on the same origin.
- **Use a layout built for each screen.** Desktop placement is bottom center; mobile uses a wide button near the bottom.
- **Keep dependencies simple.** Vanilla JavaScript and scoped CSS; no jQuery, Bootstrap, external icon fonts or hosted font dependency.
- **Use and modify it freely.** MIT licensed, with source code included.

The plugin is intended to make the next action easier to find. It does not guarantee more leads, clicks, conversions or search rankings.

## Download and install

Download **Floating-Action-Button-Bludit-Plugin-v1.2.0.zip** from this repository’s Releases section. Use the attached installable ZIP rather than GitHub’s automatically generated source archive.

1. Back up the current plugin folder and your Bludit content.
2. Extract the ZIP and upload `floatingactionbutton` into `/bl-plugins/`.
3. Confirm the path is `/bl-plugins/floatingactionbutton/plugin.php`.
4. In Bludit Admin → Plugins, activate **Floating Action Button**.
5. Open its settings, select **Yes**, enter your button text and link, set scroll percentages and save.
6. Clear any website or CDN cache and test a public page.

## Settings explained

| Setting | What it does |
| --- | --- |
| Show floating button | Turns the public button on or off. |
| Button text | Sets the visible call to action. |
| Button link | Accepts a relative URL, HTTP/HTTPS URL, mailto, tel or anchor link. |
| Desktop scroll percentage | Defaults to 30. Used above 700px viewport width. |
| Mobile scroll percentage | Defaults to 40. Used at 700px viewport width or below. |

Scroll percentage is distance scrolled divided by the available scroll distance. Set 0 to show immediately or 100 to show at the bottom. Scrolling above the threshold hides the button again. A page with no scrollable distance only shows the button at a zero threshold.

Links open in the same tab. A same-origin linked page is excluded after normalizing trailing slashes and ignoring the query string and fragment. An anchor targeting the current page also suppresses the button. An external booking page, email link or telephone link does not trigger this page exclusion. Different subdomains count as different origins.

## Example button text and destinations

| Purpose | Button text | Example link |
| --- | --- | --- |
| Contact enquiries | Contact Our Team | /contact-us/ |
| Quote requests | Request a Quote | /request-a-quote/ |
| Phone enquiries | Call Us Today | tel:+16045550123 |
| Email enquiries | Email Our Team | mailto:hello@example.com |

Replace all example destinations with your real links. The plugin does not create destination pages or booking forms.

## Responsive behavior and accessibility

The button includes a local decorative mouse icon on desktop and a finger/swipe icon on mobile beside its text. The mobile nudge animation runs three times and respects reduced-motion preferences. Decorative icons are hidden from assistive technology. The link has a visible keyboard focus style. The hidden button is removed from keyboard navigation until the scroll threshold is reached, and it is hidden when printing.

## Theme compatibility

Designed around the Bludit 3.x plugin API. The plugin metadata declares compatibility with 3.15.0; this is not certification that every version or theme has been tested. A theme must run at least one of `siteHead`, `siteBodyBegin` or `siteBodyEnd`. JavaScript is required. Multiple hooks do not create multiple buttons.

No Bludit core files or theme templates need editing when standard hooks are present. Themes missing all three hooks, restrictive Content Security Policy settings, or unusual styles on the body or HTML element may need adjustments. Test on your theme before production use.

## Upgrading

Replace the plugin files while retaining Bludit’s saved plugin settings. Do not delete `/bl-content/databases/plugins/floatingactionbutton/`. Existing enabled, text and link settings are retained. Open settings and save the desktop and mobile percentages after upgrading.

## Troubleshooting

If the button is missing, confirm activation and nonempty text/link settings, then clear caches. Scroll far enough to reach your threshold. Check a page other than the linked contact page. For a short page, temporarily set the threshold to zero.

View page source and search for `floatingactionbutton`. If absent, check activation, settings, page caches and theme hooks. If present, inspect the browser console and network panel for JavaScript, stylesheet or CSP errors. Unsafe URL schemes such as `javascript:` are rejected.

## Support and contributions

Open a GitHub issue with your Bludit version, PHP version, theme name, browser, viewport width, configured thresholds and steps to reproduce. Do not post passwords or private admin information. Contributions and reproducible bug reports are welcome.

## About the author

Created by **Amazing Marketing Agency .ca**. Visit [Amazing Marketing Agency](https://www.amazingmarketing.ca) to learn about the agency behind this free Bludit plugin.

## License

MIT. See [LICENSE](LICENSE). Free to use, modify and redistribute under the license terms. This plugin has not been submitted to or approved by Bludit as part of this package preparation.
