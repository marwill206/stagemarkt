import React from 'react';
import './header.jsx';
import '../../css/app.css';
import '../../css/style.css';
import Header from './header';

export default function Layout({ children }) {
  return (
    <div>
      <Header />
      <main>
        {children}
      </main>
    </div>
  );
}
