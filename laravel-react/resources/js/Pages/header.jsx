import React from 'react';
import dataCities from '../../json/cities.json'; // Import the JSON file

export default function Header() {
    return (
        <header className="header">
            <div className="header-top">
                <div className="logo">STAGEMARKT</div>
                <nav>
                    <a href="#">Tips</a>
                    <a href="#">FAQ</a>
                    <a href="#">Contact</a>
                    <a href="#">Nieuwe opleidingsnamen</a>
                </nav>
            </div>
        </header>
    );
}
