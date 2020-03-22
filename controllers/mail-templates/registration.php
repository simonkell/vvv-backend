<?php
    function getMailBody($confirmUrl) {
        $mailTemplateRegistration = "<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\" id=\"bodyTable\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;background-color: #FFFFFF;\">
                <tbody><tr>
                    <td align=\"center\" valign=\"top\" id=\"bodyCell\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;border-top: 0;\">
                        <!-- BEGIN TEMPLATE // -->
                        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                            <tbody><tr>
                                <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                    <!-- BEGIN PREHEADER // -->
                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"templatePreheader\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 1px solid #000000;\">
                                        <tbody><tr>
                                        	<td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"templateContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                    <tbody><tr>
                                                        <td valign=\"top\" class=\"preheaderContainer\" style=\"padding-top: 10px;padding-bottom: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnTextBlock\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
    <tbody class=\"mcnTextBlockOuter\">
        <tr>
            <td valign=\"top\" class=\"mcnTextBlockInner\" style=\"padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
              	<!--[if mso]>
				<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" style=\"width:100%;\">
				<tr>
				<![endif]-->
			    
				<!--[if mso]>
				<td valign=\"top\" width=\"600\" style=\"width:600px;\">
				<![endif]-->
                <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" width=\"100%\" class=\"mcnTextContentContainer\">
                    <tbody><tr>
                        
                        <td valign=\"top\" class=\"mcnTextContent\" style=\"padding: 0px 18px 9px;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #000000;font-family: Helvetica;font-size: 11px;line-height: 125%;\">
                        
                            <a href=\"https://us19.campaign-archive.com/?e=[UNIQID]&amp;u=6d9bcbfbe9d6f800a5a715560&amp;id=6b1d4ea71b\" target=\"_blank\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #000000;font-weight: normal;text-decoration: underline;\">View this email in your browser</a>
                        </td>
                    </tr>
                </tbody></table>
				<!--[if mso]>
				</td>
				<![endif]-->
                
				<!--[if mso]>
				</tr>
				</table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>                                            
                                        </tr>
                                    </tbody></table>
                                    <!-- // END PREHEADER -->
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                    <!-- BEGIN HEADER // -->
                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"templateHeader\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;\">
                                        <tbody><tr>
                                            <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"templateContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                    <tbody><tr>
                                                        <td valign=\"top\" class=\"headerContainer\" style=\"padding-top: 10px;padding-bottom: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnImageBlock\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
    <tbody class=\"mcnImageBlockOuter\">
            <tr>
                <td valign=\"top\" style=\"padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" class=\"mcnImageBlockInner\">
                    <table align=\"left\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"mcnImageContentContainer\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                        <tbody><tr>
                            <td class=\"mcnImageContent\" valign=\"top\" style=\"padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                
                                    
                                        <img align=\"center\" alt=\"\" src=\"https://cdn-images.mailchimp.com/template_images/gallery/logo_worn_clothing.png\" width=\"400\" style=\"max-width: 400px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;\" class=\"mcnImage\">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // END HEADER -->
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                    <!-- BEGIN BODY // -->
                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"templateBody\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;\">
                                        <tbody><tr>
                                            <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"templateContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                    <tbody><tr>
                                                        <td valign=\"top\" class=\"bodyContainer\" style=\"padding-top: 10px;padding-bottom: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnImageCardBlock\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
    <tbody class=\"mcnImageCardBlockOuter\">
        <tr>
            <td class=\"mcnImageCardBlockInner\" valign=\"top\" style=\"padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                
<table align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"mcnImageCardBottomContent\" width=\"100%\" style=\"background-color: #D83C7D;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
    <tbody><tr>
        <td class=\"mcnImageCardBottomImageContent\" align=\"center\" valign=\"top\" style=\"padding-top: 0px;padding-right: 0px;padding-bottom: 0;padding-left: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
        
            

            <img alt=\"\" src=\"https://cdn-images.mailchimp.com/template_images/gallery/Candy_colors_fashiondb5adc.jpg\" width=\"564\" style=\"max-width: 564px;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;vertical-align: bottom;\" class=\"mcnImage\">
            
        
        </td>
    </tr>
    <tr>
        <td class=\"mcnTextContent\" valign=\"top\" style=\"padding: 9px 18px;color: #FFFFFF;font-size: 16px;font-weight: bold;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;font-family: Helvetica;line-height: 150%;\" width=\"546\">
            &nbsp;
<h1 style=\"display: block;margin: 0;padding: 0;font-family: Helvetica;font-size: 40px;font-style: normal;font-weight: bold;line-height: 100%;letter-spacing: -1px;text-align: center;color: #FFFFFF !important;\">Willkommen bei&nbsp;</h1>
volunteervsvirus<br>
&nbsp;
        </td>
    </tr>
</tbody></table>




            </td>
        </tr>
    </tbody>
</table><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnTextBlock\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
    <tbody class=\"mcnTextBlockOuter\">
        <tr>
            <td valign=\"top\" class=\"mcnTextBlockInner\" style=\"padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
              	<!--[if mso]>
				<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" style=\"width:100%;\">
				<tr>
				<![endif]-->
			    
				<!--[if mso]>
				<td valign=\"top\" width=\"600\" style=\"width:600px;\">
				<![endif]-->
                <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" width=\"100%\" class=\"mcnTextContentContainer\">
                    <tbody><tr>
                        
                        <td valign=\"top\" class=\"mcnTextContent\" style=\"padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #000000;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: center;\">
                        
                            Wir sind eine junge Gruppe von Programmierern und Medizinern die im Zuge des #WirvsVirusHackathon an einer App arbeiten, die Krankenhäusern und anderen medizinischen Institutionen hilft, mögliche ehrenamtliche Mitarbeiter zu finden und zu organisieren. #VolunteerVsVirus Wir entwickeln eine Plattform , wo sich Helfer:innen registrieren können, um Hilfe verschiedener Art anzubieten. Andersrum ist es Krankenhäusern möglich, Anforderungen an Helfer zu stellen.<br>
&nbsp;
                        </td>
                    </tr>
                </tbody></table>
				<!--[if mso]>
				</td>
				<![endif]-->
                
				<!--[if mso]>
				</tr>
				</table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnButtonBlock\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
    <tbody class=\"mcnButtonBlockOuter\">
        <tr>
            <td style=\"padding-top: 0;padding-right: 18px;padding-bottom: 18px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" valign=\"top\" align=\"center\" class=\"mcnButtonBlockInner\">
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"mcnButtonContentContainer\" style=\"border-collapse: separate !important;border-radius: 4px;background-color: #DD2962;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                    <tbody>
                        <tr>
                            <td align=\"center\" valign=\"middle\" class=\"mcnButtonContent\" style=\"font-family: Arial;font-size: 16px;padding: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                <a class=\"mcnButton \" title=\"Registrierung bestätigen\" href=\"";
        $mailTemplateRegistration .= $confirmUrl;
        $mailTemplateRegistration .= "\" target=\"_blank\" style=\"font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;display: block;\">Registrierung bestätigen</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnDividerBlock\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;table-layout: fixed !important;\">
    <tbody class=\"mcnDividerBlockOuter\">
        <tr>
            <td class=\"mcnDividerBlockInner\" style=\"min-width: 100%;padding: 20px 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                <table class=\"mcnDividerContent\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-top: 1px solid #000000;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                    <tbody><tr>
                        <td style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
<!--            
                <td class=\"mcnDividerBlockInner\" style=\"padding: 18px;\">
                <hr class=\"mcnDividerContent\" style=\"border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;\" />
-->
            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // END BODY -->
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                    <!-- BEGIN COLUMNS // -->
                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"templateColumns\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;\">
                                        <tbody><tr>
                                            <td align=\"center\" valign=\"top\" style=\"padding-top: 10px;padding-bottom: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"templateContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                    <tbody><tr>
                                                        <td align=\"left\" valign=\"top\" class=\"columnsContainer\" width=\"50%\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                            <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"templateColumn\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                                <tbody><tr>
                                                                    <td valign=\"top\" class=\"leftColumnContainer\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"></td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                        <td align=\"left\" valign=\"top\" class=\"columnsContainer\" width=\"50%\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                            <table align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"templateColumn\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                                <tbody><tr>
                                                                    <td valign=\"top\" class=\"rightColumnContainer\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"></td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // END COLUMNS -->
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                    <!-- BEGIN FOOTER // -->
                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"templateFooter\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;\">
                                        <tbody><tr>
                                            <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"templateContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
                                                    <tbody><tr>
                                                        <td valign=\"top\" class=\"footerContainer\" style=\"padding-top: 10px;padding-bottom: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // END FOOTER -->
                                </td>
                            </tr>
                        </tbody></table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </tbody></table>";
        return $mailTemplateRegistration;
    }