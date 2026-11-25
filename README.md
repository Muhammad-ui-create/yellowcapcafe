# Yellow Cap Cafe

Website for Yellow Cap Cafe — good coffee, good days. Pre-launch: the cafe at
6466 N Sheridan Rd, Chicago has not opened yet.

Static HTML/CSS, no build step, plus one PHP file for the signup form. Pushes to
`main` auto-deploy to yellowcapcafe.com (Hostinger, via its GitHub app).

## Structure

- `index.html`, `menu.html`, `shop.html`, `our-story.html`, `franchise.html`, `visit.html`:
  pages. Header, footer and signup are identical on every page; change them in all six.
- `site.css`: the whole design. Brand tokens live in `:root`.
- `notify.php`: emails "be first to know" signups to info@yellowcapcafe.com and keeps a
  CSV one level above public_html, so it can never be downloaded. Needs PHP, so it
  works on Hostinger but not on the GitHub Pages copy.
- `art/svg/`: the doodle set as vectors, from the client's Yellow-Cap-Doodles pack.
- `art/logo.png`: the logo (no vector version supplied).
- `.htaccess`: hides README.md and .gitignore, since Hostinger serves the whole repo.

## Design

Layout follows Colectivo (colectivo.com): announcement strip, big hero, coloured card
row, story feature, location panel, "what's coming" strip, dark footer with signup and a
character parade. **Colours, fonts and illustrations are Yellow Cap's own and must stay so:**

| Token | Hex | Use |
|---|---|---|
| Cap Yellow | `#F7BD11` | hero, cards, buttons |
| Deep Ink | `#1D191A` | text, borders, dark blocks |
| Warm Cream | `#FAF4E6` | panels, card plates |
| Site Beige | `#FAF0DC` | page background |

Fonts: Caveat (handwritten accents) and Work Sans (everything else).

Rules learned the hard way:
- The characters have black linework, so they must sit on cream or yellow, never on black.
- The lounging character was rejected by the client and must not be used anywhere.

## Content status

Most of the original copy came from the design mock and was invented. It was removed so
nothing on the site states a fact we cannot stand behind. Removed: menu items and prices,
the shop catalogue, franchise fees and terms (regulated; do not publish numbers without the
client's sign-off), opening hours, the fake 555 phone number, promotional offers, and an
invented founding story. Verified and kept: the address and the brand artwork.

## Cache busting: read before editing site.css

Every page links the stylesheet as `site.css?v=N`. After changing `site.css`, bump `N` in
all six HTML files, or returning visitors may get new HTML with an old, cached stylesheet:

```bash
sed -i 's/site\.css?v=[0-9]*/site.css?v=NEXT/' *.html
```

## Needed from the client

1. Opening date and opening hours
2. Final menu and prices
3. Which payment system the cafe will use (decides online ordering, rewards and any app)
4. Whether the shop and franchise programme are real offerings, and on what terms
5. Real Instagram / Facebook links (none are shown until then)
6. Confirmation that info@yellowcapcafe.com can be shown publicly
