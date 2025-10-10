import React from 'react';
import './header.jsx';
import '../../css/app.css';
import '../../css/style.css';
import '../../css/index.css';
import Header from './header';
import Footer from './footer';

export default function Layout({ children }) {
  return (
    <div>
      <Header />
      <main>
        {children}
      </main>
      <Footer />
    </div>
  );
}
