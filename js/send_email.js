const nodemailer = require('nodemailer');

// Get arguments from PHP
const [, , toEmail, name, type, location, budget] = process.argv;

async function sendMail() {
    let transporter = nodemailer.createTransport({
        service: 'gmail',
        auth: {
            user: 'radhaeventmanagement@gmail.com', // Replace with your Gmail
            pass: 'qyfgdqhkjmplfwep'     // Replace with your App Password
        }
    });

    let mailOptions = {
        from: '"Radha Event Management" <your-email@gmail.com>',
        to: toEmail,
        subject: 'Event Confirmed! - Radha Event Management',
        html: `
            <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; border: 1px solid #eee; padding: 20px;">
                
                <h2 style="color: #5D09ED;">Dear ${name},</h2>
                <p>We are thrilled to inform you that your reservation with <strong>Radha Event Management</strong> has been officially confirmed!</p>
                
                <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <h3 style="margin-top: 0; color: #333;">Event Details:</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li><strong>Event Type:</strong> ${type}</li>
                        <li><strong>Location:</strong> ${location}</li>
                        <li><strong>Budget Estimate:</strong> ₹${budget}</li>
                    </ul>
                </div>

                <p>Our team is already hard at work preparing to make your event extraordinary. We will reach out to you shortly to discuss the final decor themes and timeline.</p>
                
                <p>If you have any immediate questions, feel free to reply to this email or call us at <strong>+91 7402315731</strong>.</p>
                
                <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
                <p style="font-size: 12px; color: #777; text-align: center;">
                    <strong>Radha Event Management</strong><br>
                    9/5, Subramaniam Road, Ramanathapuram, Coimbatore.
                </p>
            </div>
        `
    };

    try {
        await transporter.sendMail(mailOptions);
        console.log('Email sent successfully');
    } catch (error) {
        console.error('Error sending email:', error);
    }
}

sendMail();