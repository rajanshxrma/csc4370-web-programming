# in-class 05 - css arcade night

rajan sharma - csc 4370

live url: https://codd.cs.gsu.edu/~rsharma30/Web/inclass05/index.html
round 2 fixed file: https://codd.cs.gsu.edu/~rsharma30/Web/inclass05/css_arcade_broken.html

## round 1 findings

score: 6/6
1. cookie menu row: B (one row, outer cards touch edges, equal space between)
2. tic-tac-toe board: A (a 3x3 board)
3. axis flip: C (horizontally left-to-right because cross axis is horizontal in column mode)
4. fraction launch: A (1s is delay before animation starts)
5. the snap-back: B (snaps back to starting position because animation-fill-mode forwards is missing)
6. the missing heart: C (in normal flow with top/left/z-index ignored because position is not set)

## round 2 bug fixes (css_arcade_broken.html)

- bug 1 (zone 1 cookie menu): `.recipe-row` had `flex-direction: column;` which stacked the cards vertically. changed it to `flex-direction: row; flex-wrap: wrap;` so they sit side by side.
- bug 2 (zone 2 tic-tac-toe): `.board` had `grid-template-columns: 100px 100px;` which only made 2 columns. changed it to `grid-template-columns: repeat(3, 100px);` for a 3x3 grid.
- bug 3 (zone 3 math quest): `#answer` had `animation: moveFraction 3s ease-in-out 1s;` without a fill mode so it jumped and lost its red color at the end. added `both` (`animation: moveFraction 3s ease-in-out 1s both;`).
- bug 4 (zone 4 merch drop): `.heart` had `top`, `left`, and `z-index` but no `position` property, so the browser kept it in static flow. added `position: absolute;`.

## round 3 checkpoints (index.html)

1. flexbox header and nav: `.cabinet-header` uses `display: flex; justify-content: space-between; align-items: center;` and `.cabinet-nav` uses `display: flex; gap: var(--space);`
2. css grid: `.game-grid` uses `display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space);`
3. keyframes animation: `@keyframes coinPulse` with 0%, 50%, 100% stops using `transform` and color, applied to `.marquee-text` with `0.5s` delay and `both` fill-mode
4. positioning and z-index: `.layer-stack` has `position: relative;` and the three `.layer` divs use `position: absolute;` with `z-index` 1, 2, and 3
5. hover and focus-visible: `.tile` and nav links have `:hover` and `:focus-visible` states with `transition` on `transform` and `box-shadow`
6. custom properties and media query: uses `:root` variables and `@media (max-width: 768px)` to stack the header and switch the grid to 2 columns
