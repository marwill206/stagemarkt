import React from 'react';
import '../../css/app.css';
import '../../css/style.css';

export default function header() {
    return (
        <header className="header">
            <div className="header-top">
                <div className="logo">
                    STAGEMARKT
                </div>
                <nav>
                    <a href="#">Tips</a>
                    <a href="#">FAQ</a>
                    <a href="#">Contact</a>
                    <a href="#">Nieuwe opleidingsnamen</a>
                </nav>
            </div>
            <div className="header-bottom">
                <div className="search-image"></div>
                <div className="search">
                    <div className="search-section">
                        <label htmlFor="opleiding">Opleiding, bedrijfsnaam of trefwoord</label>
                        <input type="search" className="search-input" name="opleiding"/>
                    </div>
                    <div className="search-section">
                        <label htmlFor="locatie">Plaats of postcode</label>
                        <input type="search" className="search-input" name="locatie"/>
                        <select name="locatie-range" className="search-input">
                            <option value="0">+0km</option>
                            <option value="5">+5km</option>
                            <option value="10">+10km</option>
                        </select>
                    </div>
                    <div className="search-section">
                        <input type="submit" value="Zoeken" />
                    </div>

                    
                    
                </div>
            </div>
        </header>
    );
}
