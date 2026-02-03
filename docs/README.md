# Find your relevant CSS style from here

![<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30"><path d="m26.545 10.486-10.97-7.313a1.05 1.05 0 0 0-1.153 0L3.453 10.486a1.05 1.05 0 0 0-.455.858v7.313c0 .333.174.67.455.858l10.97 7.313c.375.229.774.234 1.153 0l10.97-7.313a1.05 1.05 0 0 0 .455-.858v-7.312a1.05 1.05 0 0 0-.455-.858M16.032 5.958l8.076 5.386-3.604 2.409-4.471-2.987zm-2.063 0v4.809l-4.471 2.987-3.605-2.409zM5.063 13.27 7.646 15l-2.583 1.725zm8.907 10.767-8.078-5.381 3.604-2.409 4.471 2.987zm1.03-6.6L11.358 15 15 12.563 18.642 15zm1.032 6.604v-4.809l4.471-2.987 3.604 2.409zm8.907-7.313L22.355 15l2.583-1.73v3.454z" fill="#fff"/></svg> Codepen Example](https://codepen.io/santanup789/full/myevELN)

## For gradient border with a border radius....

```html
<div class="card">
    <a class="bde-button__button" href="#" target="_self" data-type="url">
        <span class="button-atom__text">Contact Us</span>
    </a>
</div>

<style>
body {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #vavava;
}
a {
  text-decoration: none;
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  vertical-align: middle;
  user-select: none;
  appearance: none;
  box-sizing: border-box;
  margin: 0;
  border: 0;
  background: linear-gradient(to right,rgba(255,255,255,0.6),transparent);
  padding: 15px 46px;
  transition: 0.3s;
  border-radius: 9999px;
  border-width: 0px;
  color: #E10514;
  font-family: "Roboto",sans-serif;
  font-size: 18px;
  font-weight: 700;
  line-height: 1.4em;
}
a:hover {
	color: #fff !important;
}
a::before {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 50px;
  padding: 2px;
  background: linear-gradient(90deg,#E10514,#fff);
  -webkit-mask: linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);
    mask-composite: add, add;
  -webkit-mask-composite: xor;
  mask-composite: exclude;
  pointer-events: none;
  z-index: -1;
}
a::after {
	content: '';
	background: #e10514;
  border-radius: 999px;
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	opacity: 0;
	z-index: -1;
	transition: 0.7s;
}
a:hover::after {
	opacity: 1;
}
</style>

