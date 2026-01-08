import { Resend } from 'resend';

const resend = new Resend(process.env.RESEND_API_KEY);

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Method not allowed' });
  }

  const { company, email, teamSize, location, engagementType, tools, challenge } = req.body;

  if (!company || !email || !teamSize || !location || !engagementType || !tools || !challenge) {
    return res.status(400).json({ error: 'All fields are required' });
  }

  try {
    const { data, error } = await resend.emails.send({
      from: 'BackOffice Systems <noreply@manageonsite.com>',
      to: ['info@manageonsite.com'],
      subject: `New Introduction Request from ${company}`,
      html: `
        <h2>New Introduction Request</h2>
        <p><strong>Company:</strong> ${company}</p>
        <p><strong>Email:</strong> ${email}</p>
        <p><strong>Team Size:</strong> ${teamSize}</p>
        <p><strong>Location:</strong> ${location}</p>
        <p><strong>Preferred Engagement:</strong> ${engagementType === 'on-site' ? 'On-Site Assessment' : engagementType === 'remote' ? 'Remote Consultation' : 'Flexible / Discuss'}</p>
        
        <h3>Current Systems & Tools</h3>
        <p>${tools.replace(/\n/g, '<br>')}</p>
        
        <h3>What They're Looking to Improve</h3>
        <p>${challenge.replace(/\n/g, '<br>')}</p>
      `,
    });

    if (error) {
      console.error('Resend error:', error);
      return res.status(400).json({ error: error.message });
    }

    return res.status(200).json({ success: true, data });
  } catch (error) {
    console.error('Server error:', error);
    return res.status(500).json({ error: 'Failed to send email' });
  }
}
