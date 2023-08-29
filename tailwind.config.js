module.exports = {
  content: ["*.php"],
  theme: {
    extend: {
      colors: {
        primary: "#8bc3b3",
        secondary: "#c3e2dc",
        secondary2: "#297576",
      },
      fontFamily: {
        "sans-pro": ["Source Sans Pro", "sans-serif"],
      },
      screens: {
        xsm: { max: "383px" },
        smx: { max: "530px" },
        sm: "640px",
      },
    },
    fontWeight: {
      light: 300,
      normal: 400,
      semibold: 600,
      bold: 700,
      extrabold: 800,
    },
  },
  plugins: [],
};
