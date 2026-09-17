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

## TODO

- Franchise: fill in placeholders (`[fee]`, `[fit out cost]`, `[floor area]`, `[weeks]`, `[Term]`)
- Franchise enquiry form has no backend yet (shows a confirmation note only)
- Shop "Add" buttons are not wired to a cart
- Social links in footer are placeholders
