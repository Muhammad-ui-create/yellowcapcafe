# Yellow Cap Cafe

Website for Yellow Cap Cafe — good coffee, good days.

Static HTML/CSS, no build step. Open `index.html` or serve the folder:

```bash
npx serve .
```

## Structure

- `index.html`, `menu.html`, `shop.html`, `our-story.html`, `franchise.html`, `visit.html` — pages (header/footer duplicated in each; keep them in sync)
- `styles.css` — design tokens (`:root`) + section styles
- `art/` — logo, illustrations, doodles, product drawings

Doodle intensity: set `--scatter-opacity` in `styles.css` (`0` off, `0.85` sparse, `1` lively).

## Content status

Most of the original copy came from the design mock and was invented. It has been
removed so nothing on the live site states a fact we cannot stand behind.

Replaced with "coming soon" placeholders, pending real content from the client:

- **Menu** — all items and prices removed (menu.html + homepage preview)
- **Shop** — all 10 products, prices and Add buttons removed
- **Franchise** — fees, fit-out costs, terms, the 5-step process, FAQ answers and
  the enquiry form removed. (Published franchise terms are regulated; do not put
  numbers back without the client's sign-off.)
- **Hours** — removed everywhere, shown as "To be confirmed"
- **Phone / email** — 555 0142 was a fake-number prefix; both removed
- **Our Story** — invented founding history, roastery and regulars replaced with
  honest copy
- **Promos** — "first 1000 get a welcome kit", "second one is on the house on
  Sundays", "first one is on us", "free local delivery over 40" all removed
- **Visit** — invented parking, transit and group-booking details removed

Verified true and kept: the address (6466 N Sheridan Rd), the brand identity and
artwork, and the Sheridan/Loyola street names on the sketch map.

## Needed from the client

1. Is the cafe **open yet**? Copy is currently neutral on this; it should say so either way.
2. Real opening hours
3. A real phone number and email address
4. Final menu and prices
5. Whether the shop and franchise programme are real offerings, and on what terms
6. Real social media URLs (footer links are still "#")
