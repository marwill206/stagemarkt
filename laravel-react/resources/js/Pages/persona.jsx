import React from 'react';
import '../../css/app.css';
import '../../css/style.css';
import '../../css/persona.css';

import userIcon from '../../images/user-icon.svg'
import genderIcon from '../../images/gender-icon.svg'
import locationIcon from '../../images/location-icon.svg'
import workIcon from '../../images/work-icon.svg'
import pathIcon from '../../images/path-icon.svg'

export default function persona() {
    return (
        <main className="main-persona">
            <aside>
                <h2 className="persona-name">John Doe</h2>
                <p className="persona-work">Company dOE</p>
                <img className="persona-img" src="https://static.vecteezy.com/system/resources/thumbnails/055/775/407/small_2x/silhouette-of-a-person-on-transparent-background-studio-setting-portrait-minimalist-dramatic-lighting-png.png" alt="Unknown person" />
            </aside>
            <section className="persona-info-wrapper">
                <div className="persona-info">
                    <h2>Persoonlijke gegevens</h2>
                    <label>
                        <img className="persona-icon" src={userIcon} alt="Age icon" />
                        <p className="persona-value">21</p>
                    </label>
                    <label>
                        <img className="persona-icon" src={workIcon} alt="work icon" />
                        <p className="persona-value">Het Bureau</p>
                    </label>
                    <label>
                        <img className="persona-icon" src={genderIcon} alt="Gender icon" />
                        <p className="persona-value">Man</p>
                    </label>
                    <label>
                        <img className="persona-icon" src={pathIcon} alt="path icon" />
                        <p className="persona-value">Webdeveloper</p>
                    </label>
                    <label>
                        <img className="persona-icon" src={locationIcon} alt="Location icon" />
                        <p className="persona-value">Terwijde</p>
                    </label>
                </div>
                <div className="persona-traits">
                    <h2>Eigenschappen</h2>
                    <p>Kalm</p>
                    <p>Sociaal</p>
                    <p>Behulpzaam</p>
                    <p>Nieuwsgierig</p>
                    <p>Leergierig</p>
                </div>
                <div className="persona-communication">
                    <h2>Communicatie</h2>
                    <label></label>
                </div>
                
            </section>
        </main>
    );
}
