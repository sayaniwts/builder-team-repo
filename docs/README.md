# Find your relevant CSS style from here

![Codepen Example](https://codepen.io/santanup789/full/myevELN)

## For gradient border with a border radius....
<pre>
<a class="bde-button__button" href="#" target="_self" data-type="url">
  <span class="button-atom__text">Contact Us</span>
</a>
</pre>

<pre>
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
</pre>

