// Tailwind CSS Configuration File
window.tailwind.config = {
    // Enable dark mode based on a class toggle
    darkMode: ['class'],

    // Theme configuration
    theme: {
        extend: {
            // Extend default colors using custom variables
            colors: {
                // Border color
                border: 'hsl(var(--border))',
                // Input field background color
                input: 'hsl(var(--input))',
                // Focus ring color
                ring: 'hsl(var(--ring))',
                // Background color
                background: 'hsl(var(--background))',
                // Text (foreground) color
                foreground: 'hsl(var(--foreground))',

                // Custom color groups
                primary: {
                    DEFAULT: 'hsl(var(--primary))', // Primary color
                    foreground: 'hsl(var(--primary-foreground))' // Primary text color
                },
                secondary: {
                    DEFAULT: 'hsl(var(--secondary))', // Secondary color
                    foreground: 'hsl(var(--secondary-foreground))' // Secondary text color
                },
                destructive: {
                    DEFAULT: 'hsl(var(--destructive))', // Destructive (error/warning) color
                    foreground: 'hsl(var(--destructive-foreground))' // Destructive text color
                },
                muted: {
                    DEFAULT: 'hsl(var(--muted))', // Muted color
                    foreground: 'hsl(var(--muted-foreground))' // Muted text color
                },
                accent: {
                    DEFAULT: 'hsl(var(--accent))', // Accent color
                    foreground: 'hsl(var(--accent-foreground))' // Accent text color
                },
                popover: {
                    DEFAULT: 'hsl(var(--popover))', // Popover background color
                    foreground: 'hsl(var(--popover-foreground))' // Popover text color
                },
                card: {
                    DEFAULT: 'hsl(var(--card))', // Card background color
                    foreground: 'hsl(var(--card-foreground))' // Card text color
                },
            },

            // Additional extensions (if needed)
            spacing: {
                // Add custom spacing utilities if required
            },
            fontFamily: {
                // Define custom font families if needed
            },
            fontSize: {
                // Define custom font sizes if needed
            },
            boxShadow: {
                // Define custom box shadows if needed
            },
        },
    },

    // Plugins configuration (optional)
    plugins: [
        // Example: Adding typography plugin for rich text styling
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'), // Enhance form elements
    ],
};