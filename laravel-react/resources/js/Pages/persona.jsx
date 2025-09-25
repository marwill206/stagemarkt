import React from 'react';
import '../../css/app.css';
import '../../css/style.css';
import '../../css/persona.css';

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
                    <label htmlFor="">
                        <img className="persona-icon" src="https://static.vecteezy.com/system/resources/thumbnails/055/775/407/small_2x/silhouette-of-a-person-on-transparent-background-studio-setting-portrait-minimalist-dramatic-lighting-png.png" alt="Unknown person" />
                    </label>
                </div>
                
            </section>
        </main>
    );
}
