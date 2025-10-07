import React from 'react';
import dataCities from '../../json/cities.json'; // Import the JSON file
import Layout from './Layout';

export default function Index() {
    return (
        <div>
            <div className="header-bottom">
                <div className="search-image"></div>
                <div className="search">
                    <div className="search-top">
                        <div className="search-section">
                            <label htmlFor="opleiding">
                                Opleiding, bedrijfsnaam of trefwoord
                            </label>
                            <input type="search" className="search-input" name="opleiding"/>
                        </div>
                        <div className="search-section">
                            <label htmlFor="locatie">Plaats of postcode</label>
                            <input type="search" className="search-input" id="input-location" name="locatie" list="locatie"/>
                            <datalist id="locatie">
                                {Array.isArray(dataCities.value) && dataCities.value.map(city => (
                                    <option key={city.Key} value={city.Title}>{city.Title}</option>
                                ))}
                            </datalist>
                            <select name="locatie-range" className="search-input">
                                <option value="0">+0km</option>
                                <option value="5">+5km</option>
                                <option value="10">+10km</option>
                                <option value="20">+20km</option>
                                <option value="50">+50km</option>
                            </select>
                        </div>
                        <div className="search-section" id="search-button">
                            <input type="submit" value="Zoeken" />
                        </div>
                    </div>
                    <div className="search-bottom">
                        <div className="search-section">
                            <h2>Zoeken naar</h2>
                            <p>Stages</p>
                            <label className="switch">
                            <input type="checkbox" />
                            <span className="slider round"></span>
                            </label>
                            <p>Leerbedrijven</p>
                        </div>
                        <div className="search-section">
                            <h2>Land</h2>
                            <select>
                                <option value="nl">Nederland</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

// Attach layout so Inertia or pages themselves can use it
Index.layout = page => <Layout>{page}</Layout>;