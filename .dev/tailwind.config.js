/** @type {import('tailwindcss').Config} */

module.exports = {
	content: [
		'./src/**/*.{svg,css,png,jpg,js}',
		'./src/**/*.php',
		'./src/**/**/*.php',
	],
	plugins: [
		require('@tailwindcss/typography')
	]
}
