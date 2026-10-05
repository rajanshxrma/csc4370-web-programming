# hw2 critical thinking answers

rajan sharma - csc 4370 (undergraduate)

## 1. cascade investigation

if i remove `background-color: #E1D697;` from the `.quote` rule in `styles.css`:

```css
.quote {
    display: flow-root;
    padding: 8px;
    border: 2px solid gray;
    background-color: #E1D697;
    font-weight: bold;
}
```

then in chrome devtools the computed `background-color` of all 8 review quote boxes changes from `rgb(225, 214, 151)` (`#E1D697`) to `rgba(0, 0, 0, 0)` (transparent).

all 8 boxes change at once because they all use the same `.quote` class selector. once that line is removed, no other css rule sets a background on `.quote`, and since `background-color` is not inherited in css, the quote boxes become transparent and show the repeating `images/background.png` image from the `body` rule behind them.

## 2. responsive trade-off at 480px

at a 480px mobile viewport width, `#main` and `#overview` stack into a single column (`456px` wide inside the 8px page margins and 4px border), and each `.column` stacks vertically at full width so there is 0px of horizontal scroll (`scrollWidth` is 480px).

for the top banner (`#banner`), `banner.png` is 974px wide, so i used:

```css
#banner {
    overflow: hidden;
    background: url("images/bannerbackground.png") repeat-x;
}
```

if i change `overflow: hidden` to `overflow: visible` at 480px, the 974px banner image sticks out to the right and causes a horizontal scrollbar (`scrollWidth` jumps to 974px). keeping `overflow: hidden` crops the right side of the film strip on small screens so the rancid tomatoes title stays full size on the left without causing sideways scrolling on mobile.
