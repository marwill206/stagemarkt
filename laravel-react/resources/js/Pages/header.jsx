import React from 'react';

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
                    <a href="/logout" className="logout-link">
                                Logout
                            </a>
                </nav>
            </div>
        </header>
    );
}
